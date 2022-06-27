<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ordenes
            </h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Identificacion</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data_orders" :key="item.id">
                        <th scope="row">{{ item.id }}</th>
                        <td>
                            {{
                                item.customer_name + " " + item.customer_surname
                            }}
                        </td>
                        <td>{{ item.status }}</td>
                        <td>
                            {{
                                item.customer_identification_type +
                                " " +
                                item.customer_identification
                            }}
                        </td>
                        <td>{{ item.total }}</td>
                        <td v-if="item.status == 'CREATED'">
                            <button
                                class="btn btn-primary"
                                style="background-color: #0d6efd"
                                @click="createPayment(item.id)"
                            >
                                <i class="fa fa-money" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            data_orders: null,
        };
    },

    mounted() {
        this.listOrders();
    },

    methods: {
        listOrders() {
            axios.get("/list-orders").then((response) => {
                this.data_orders = response.data;
            });
        },

        createPayment(id) {
            const data_order = {
                id: id,
            };
            axios.post(`payment`, data_order).then((response) => {
                window.location = response.data;
            });
        },
    },
};
</script>
