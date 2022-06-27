<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Orden
            </h2>
            <form @submit.prevent="createOrder">
                <div class="row">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Nombre</label>
                        <input
                            type="text"
                            required
                            class="form-control"
                            id="name"
                            placeholder="Nombre"
                            v-model="customer_name"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="surname" class="form-label">Apellido</label>
                        <input
                            type="text"
                            required
                            class="form-control"
                            id="surname"
                            placeholder="Apellido"
                            v-model="customer_surname"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">Correo</label>
                        <input
                            type="email"
                            required
                            class="form-control"
                            id="email"
                            placeholder="Correo"
                            v-model="customer_email"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label"
                            >Numero de telefono</label
                        >
                        <input
                            type="number"
                            required
                            class="form-control"
                            id="phone"
                            placeholder="Numero de telefono"
                            v-model="customer_phone"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label"
                            >Tipo de identificacion</label
                        >
                        <select
                            class="form-select"
                            aria-label="Default select example"
                            v-model="customer_identification_type"
                        >
                            <option value="CC">Cedula de ciudadania</option>
                            <option value="NIT">NIT</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="identification" class="form-label"
                            >Numero de identificacion</label
                        >
                        <input
                            type="number"
                            required
                            class="form-control"
                            id="identification"
                            placeholder="Numero de identificacion"
                            v-model="customer_identification"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="product_name" class="form-label"
                            >Nombre del producto</label
                        >
                        <input
                            type="text"
                            required
                            class="form-control"
                            id="product_name"
                            placeholder="Nombre del producto"
                            v-model="product_name"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="product_price" class="form-label"
                            >Precio</label
                        >
                        <input
                            type="number"
                            min="100"
                            required
                            class="form-control"
                            id="product_price"
                            placeholder="Precio"
                            v-model="product_price"
                        />
                    </div>
                    <div class="col-md-4">
                        <label for="product_quantity" class="form-label"
                            >Cantidad</label
                        >
                        <input
                            type="number"
                            min="1"
                            required
                            class="form-control"
                            id="product_quantity"
                            placeholder="Cantidad"
                            v-model="product_quantity"
                        />
                    </div>
                </div>
                
                <br />
                <div class="col-12">
                    <button
                        class="btn btn-primary"
                        style="background-color: #0d6efd"
                        type="submit"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </template>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            customer_name: null,
            customer_surname: null,
            customer_email: null,
            customer_identification_type: null,
            customer_identification: null,
            customer_phone: null,
            product_name: null,
            product_price: null,
            product_quantity: null,
            message:null,
        };
    },

    methods: {
        createOrder() {
            const data_order = {
                customer_name: this.customer_name,
                customer_surname: this.customer_surname,
                customer_email: this.customer_email,
                customer_identification_type: this.customer_identification_type,
                customer_identification: this.customer_identification,
                customer_phone: this.customer_phone,
                product_name: this.product_name,
                product_price: this.product_price,
                product_quantity: this.product_quantity,
            };

            axios.post("/create", data_order).then((response) => {
                message = response.message;
            });
        },
    },
};
</script>
