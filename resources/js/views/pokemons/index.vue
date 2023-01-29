<template>
    <div>
      <div class="flex justify-center mb-4">
        <input
          class="border p-2 rounded"
          type="text"
          v-model="search"
          placeholder="Search for pokemons..."
        />
      </div>
      <div class="flex flex-wrap">
        <div
          class="w-1/3 mb-4 px-4"
          v-for="(pokemon, index) in filteredPokemons" :key="index"
        >
          <div class="bg-white rounded-lg p-4">
            <div class="text-lg font-medium">{{ pokemon.name }}</div>
            <div class="flex justify-between">
              
              <div>
                <button class="bg-blue-500 text-white px-2 py-1 rounded-lg mr-2">
                    <div
                      v-if="!pokemon.type.includes('LIKED')"
                      @click="markPokemon(pokemon, 'LIKE')"
                    >
                      <font-awesome-icon :icon="['far', 'thumbs-up']"/> Like
                    </div>

                    <div
                      v-else-if="pokemon.type.includes('LIKED')"
                      @click="markPokemon(pokemon, 'LIKED')"
                    >
                        <font-awesome-icon :icon="['fas', 'thumbs-up']"/> Liked
                    </div>
                </button>

                <button class="bg-red-500 text-white px-2 py-1 rounded-lg mr-2">
                    <div
                      v-if="!pokemon.type.includes('HATED')"
                      @click="markPokemon(pokemon, 'HATE')"
                    >
                        <font-awesome-icon :icon="['far', 'thumbs-down']"/> Hate
                    </div>

                    <div
                      v-else-if="pokemon.type.includes('HATED')"
                      @click="markPokemon(pokemon, 'HATED')"
                    >
                        <font-awesome-icon :icon="['fas', 'thumbs-down']"/> Hated
                    </div>
                </button>

                <button class="bg-green-500 text-white px-2 py-1 rounded-lg">
                    <div
                      v-if="!pokemon.type.includes('FAVORITED')"
                      @click="markPokemon(pokemon, 'FAVORITE')"
                    >
                       <font-awesome-icon :icon="['far', 'heart']"/> Favorite
                    </div>

                    <div
                      v-else-if="pokemon.type.includes('FAVORITED')"
                      @click="markPokemon(pokemon, 'FAVORITED')"
                    >
                        <font-awesome-icon :icon="['fas', 'heart']"/> Favorited
                    </div>
                </button>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="flex justify-center">
        <button
          class="bg-blue-500 text-white px-4 py-2 rounded-lg mr-2"
          @click="prevPage"
          :disabled="currentPage === 1"
        >
          Previous
        </button>
        <button
          class="bg-blue-500 text-white px-4 py-2 rounded-lg"
          @click="nextPage"
          :disabled="currentPage === maxPage"
        >
          Next
        </button>
      </div>
    </div>
  </template>
  
<script>
  import { http } from '@/services/http.js';
  import { ref, computed } from 'vue';
  import { createToaster } from "@meforma/vue-toaster";

  export default {
    setup() {
        const pokemons = ref([]);
        const search = ref('');
        const currentPage = ref(1);
        const perPage = ref(20);
        const userSelections = ref([]);

        // computed properties
        const filteredPokemons = computed(() => {
            return pokemons.value.filter((pokemon) => {
                return pokemon.name.toLowerCase().includes(search.value.toLowerCase());
            });
        });

        const maxPage = computed(() => {
            return Math.ceil(filteredPokemons.value.length / perPage.value);
        });
    
        // methods
        const prevPage = () => {
            currentPage.value--;
        };

        const nextPage = () => {
            currentPage.value++;
        };

        const fetchPokemons = async () => {
            const response = await http.get('pokemon');

            const data = response.data.results;

            const selections = await fetchAuthUser();

            data.forEach((value) => {
                value.type = [];
                selections.forEach((selection) => {
                    if (value.name === selection.pokemon) {
                        value.type.push(selection.formatted_type);
                    }
                });
            });
            
            pokemons.value.push(...data);
        };

        fetchPokemons();

        const fetchAuthUser = async () => {
            const response = await http.get('user');

            return response.data.selections;
        };

        // 
        const markPokemonRequest = async (url, payload, action) => {
            const toaster = createToaster();

            if (action === 'POST') {
                const response = await http.post(`pokemon/${url}`, payload);

                if (response.status === 200) {
                    toaster.show('Success', {
                        type: 'success',
                        position: 'bottom-left',
                        duration: 3500, 
                    });
                } else if (response.status === 422) {
                    toaster.show(response.data.message, {
                        type: 'error',
                        position: 'bottom-left',
                        duration: 3500,
                    });
                }

                return response.status;
            }
            // Delete
            else {
                const response = await http.delete(`pokemon/${url}`, payload);

                if (response.status === 204) {
                    toaster.show('Success', {
                        type: 'success',
                        position: 'bottom-left',
                        duration: 3500,
                    });
                } else if (response.status === 422) {
                    toaster.show(response.data.message, {
                        type: 'error',
                        position: 'bottom-left',
                        duration: 3500,
                    });
                }

                return response.status;
            }
        };

        const markPokemon = async (pokemon, type) => {
            switch(type) {
                case 'LIKE':
                  const markAsLiked = await markPokemonRequest('mark-as-liked', { name: pokemon.name }, 'POST');

                  if (markAsLiked === 200) {
                      pokemon.type.push('LIKED');
                  }
                break;

                case 'LIKED':
                  const removeAsLiked = await markPokemonRequest('remove-as-liked', { name: pokemon.name }, 'DELETE');

                  if (removeAsLiked === 204) {
                     pokemon.type.splice(pokemon.type.indexOf(type), 1);
                  }
                break;

                case 'HATE':
                  const markAsHated = await markPokemonRequest('mark-as-hated', { name: pokemon.name }, 'POST');

                  if (markAsHated === 200) {
                      pokemon.type.push('HATED');
                  }
                break;

                case 'HATED':
                  const removeAsHated = await markPokemonRequest('remove-as-hated', { name: pokemon.name }, 'DELETE');

                  if (removeAsHated === 204) {
                    pokemon.type.splice(pokemon.type.indexOf(type), 1);
                  }
                break;

                case 'FAVORITE':
                  const markAsFavorite = await markPokemonRequest('mark-as-favorite', { name: pokemon.name }, 'POST');

                  if (markAsFavorite === 200) {
                      pokemon.type.push('FAVORITED');
                  }
                break;

                case 'FAVORITED':
                  const removeAsFavorited = await markPokemonRequest('remove-as-favorite', { name: pokemon.name }, 'DELETE');

                  if (removeAsFavorited === 204) {
                      pokemon.type.splice(pokemon.type.indexOf(type), 1);
                  }
                break;
            }
        };

        return {
            pokemons,
            search,
            currentPage,
            perPage,
            filteredPokemons,
            maxPage,
            prevPage,
            markPokemon,
        };
    }
}
</script>
