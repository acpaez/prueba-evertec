<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import axios from "axios";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pay Order
            </h2>
            <table class="table" v-if="data_orders.length > 0">
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
            data_orders: [],
        };
    },

    mounted() {
        this.statusOrder();
    },

    methods: {
        statusOrder() {
            var queryString = window.location.search;
            var urlParams = new URLSearchParams(queryString);
            var anuncioParam = urlParams.get("reference");
            axios
                .post("/status-pay", { reference: anuncioParam })
                .then((response) => {
                    this.data_orders.push(response.data);
                });
        },
    },
};
</script>
