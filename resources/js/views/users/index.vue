<template>
    <div class="container mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">User List</h1>
        <table class="table-auto w-full text-center">
            <thead class="bg-gray-200">
            <tr class="text-xs font-medium">
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>

                <th class="px-4 py-2">Liked</th>
                <th class="px-4 py-2">Hated</th>
                <th class="px-4 py-2">Favorited</th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-sm" v-for="user in formattedUsers" :key="user.id">
                <td class="border px-4 py-2">{{ user.first_name }}</td>
                <td class="border px-4 py-2">{{ user.email }}</td>

                <td class="border px-4 py-2">
                    <div v-for="favorite in user.LIKED" :key="favorite.id">
                        {{ favorite.pokemon }}
                    </div>
                </td>
                
                <td class="border px-4 py-2">
                    <div v-for="favorite in user.HATED" :key="favorite.id">
                        {{ favorite.pokemon }}
                    </div>
                </td>

                <td class="border px-4 py-2">
                    <div v-for="favorite in user.FAVORITED" :key="favorite.id">
                        {{ favorite.pokemon }}
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

// Vue
import { computed, ref } from 'vue';

// Http
import { http } from '@/services/http.js';

export default {
    setup() {

        const users = ref([]);

        const fetchAuthUser = async () => {
            const response = await http.get('user/list');

            if (response.status === 200) {
                users.value.push(...response.data.data);
            }
        };

        fetchAuthUser();

        const formattedUsers = computed(() => {
            return users.value.map((user) => {
                const userData = {
                    first_name: user.first_name,
                    last_name: user.last_name,
                    email: user.email,
                    'LIKED': [],
                    'HATED': [],
                    'FAVORITED': [],
                };

                user.selections.forEach((selection) => {
                    userData[selection.formatted_type].push(selection);
                });

                return userData;
            });
        });

        return {
            users,
            formattedUsers,
        };
    },
};
</script>
  