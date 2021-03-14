<template>
  <breeze-authenticated-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            You're logged in!
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-center">
      <button
        class="bg-blue-600 hover:bg-blue-500 text-white font-semibold p-3 mb-7"
        @click="openform"
        v-if="showButton"
      >
        click to pay on razorpay
      </button>
    </div>

    <div class="xs:w-full sm:w-full md:w-full max-w-7xl mx-auto lg:px-8">
      <form @submit.prevent="submit" class="form bg-white p-6 my-10 relative">
        <div
          class="icon bg-blue-600 text-white w-6 h-6 absolute flex items-center justify-center p-5"
          style="left: -40px"
        >
          <i
            class="fal fa-phone-volume fa-fw text-2xl transform -rotate-45"
          ></i>
        </div>
        <h3 class="text-2xl mt-5 text-gray-900 font-semibold">Name</h3>
        <input
          type="text"
          placeholder="input name"
          class="border p-2 w-full mt-3"
          v-model="form.name"
        />
        <h3 class="text-2xl text-gray-900 font-semibold">
          Payment Gateway for razorpay
        </h3>
        <input
          type="number"
          placeholder="input amount"
          class="border p-2 w-full mt-3"
          v-model="form.amount"
        />
        <button
          class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold p-3 mb-7"
          @click="pay"
        >
          Pay
        </button>
      </form>
    </div>
  </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import razorpay from "razorpay";

export default {
  components: {
    BreezeAuthenticatedLayout,
  },

  name: "Dashboard",

  data() {
    return {
      form: { name: "", amount: "" },
      options: {},
      showButton: false,
    };
  },

  mounted() {
    this.options = {
      key: "YOUR_KEY_ID",
      amount: "2000", // 2000 paise = INR 20
      name: "Merchant Name",
      description: "Purchase Description",
      image:
        "https://user-images.githubusercontent.com/15979712/27070335-deffe080-5018-11e7-82e8-2a299cb9e99b.png",
      order_id: "",
      handler: function (response) {
        console.log(response);
        axios
          .post("/razorpay-hook", response)
          .then((response) => {
            alert("Payment Successfull");
            
            console.log('returned',response);
          })
          .catch((response) => {
            console.log(response.data.errors);
            alert("error occured");
          });
      },
      prefill: {
        name: "XYZ Kumar",
        email: "test@test.com",
      },
      notes: {
        address: "Hello World",
      },
      theme: {
        color: "#F37254",
      },
    };
  },

  methods: {
    submit() {
      var self = this;

      axios
        .post("/payment", this.form)
        .then(function (response) {
          self.options.key = response.data.key;
          self.options.amount = response.data.amount * 100;
          self.options.order_id = response.data.order_id;

          self.showButton = true;
          console.log(response.data);
        })
        .catch(function (error) {
          alert("error occured");
          console.log(error);
        });
    },

    openform() {
      var rzp1 = new Razorpay(this.options);

      rzp1.open();
    },
  },
};
</script>
