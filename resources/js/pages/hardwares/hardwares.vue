<template>
  <card title="Hardware List">
    <div>
      <b-table
        borderless
        :items="items"
        :fields="fields"
        :busy="isBusy"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
      >
        <template v-slot:cell(show_details)="row">
          <!-- Using value -->
          <b-button
            @click="get_product(row.item.id)"
            size="sm"
            v-b-modal="'product-modal' + row.item.id"
          >Show Details</b-button>
          <!-- The modal -->
          <b-modal :id="'product-modal' + row.item.id" title="Update Hardware">
            <b-alert
              variant="success"
              dismissible
              :show="showAlert"
              @dismissed="showAlert=false"
            >Hardware updated!</b-alert>
            <b-form @submit.prevent="update_product(row.item.id)">
              <!-- Product Name -->
              <b-form-group id="input-group-1" label="Hardware Name:" label-for="input-1">
                <div v-if="product">
                  <b-form-input id="input-1" v-model="product[0].hardwareName" type="text" required></b-form-input>
                </div>
              </b-form-group>
              <!-- Product Quantity -->
              <b-form-group id="input-group-1" label="Hardware Quantity:" label-for="input-1">
                <div v-if="product">
                  <b-form-input id="input-1" v-model="product[0].hardwareQuantity" type="number"></b-form-input>
                </div>
              </b-form-group>
              <b-button size="sm" variant="success" type="submit">Update</b-button>
            </b-form>
            <template v-slot:modal-footer="{ ok, cancel, hide }">
              <b-button size="sm" variant="outline-success" @click="hide('forget')">Approve</b-button>
              <b-button size="sm" variant="danger" @click="cancel()">Close</b-button>
              <!-- Button with custom close trigger value -->
            </template>
          </b-modal>
        </template>
        <template v-slot:cell(productStatus)="row">
          <b-badge
            v-if="row.item.productStatus == 'Not Approved'"
            variant="danger"
          >{{ row.item.productStatus }}</b-badge>
          <b-badge
            v-if="row.item.productStatus == 'Approved'"
            variant="success"
          >{{ row.item.productStatus }}</b-badge>
        </template>
      </b-table>
    </div>
    <div class="float-right">
      <router-link :to="{ name: add_material.route }">
        <b-button variant="outline-primary">Add Hardware</b-button>
      </router-link>
    </div>
  </card>
</template>

<script>
export default {
  middleware: "auth",
  computed: {
    add_material() {
      return {
        name: "Add Hardware",
        route: "bom.add_hardware"
      };
    }
  },
  mounted() {
    this.$root.$on("bv::modal::hide", (bvEvent, modalId) => {
      this.refresh_products();
      this.showAlert = false;
    });
  },
  data() {
    return {
      showAlert: false,
      sortBy: "created_at",
      sortDesc: true,
      fields: [
        { key: "hardwareName", sortable: true },
        { key: "hardwareQuantity", sortable: true },
        { key: "created_at", sortable: true },
        { key: "show_details", sortable: true }
      ],
      items: null,
      isBusy: true,
      product: null
    };
  },
  created() {
    this.toggleBusy();
    fetch("/api/hardware")
      .then(response => response.json())
      .then(data => (this.items = data));
    this.toggleBusy();
  },
  updated() {
    this.isBusy = false;
  },
  methods: {
    toggleBusy() {
      this.isBusy = !this.isBusy;
    },
    get_product(id) {
      fetch("/api/hardware/" + id)
        .then(response => response.json())
        .then(data => (this.product = data));
    },
    update_product(id) {
      this.$http.post("/api/hardware/" + id, this.product, function(data) {});
      this.showAlert = true;
    },
    refresh_products() {
      this.isBusy = true;
      fetch("/api/hardware")
        .then(response => response.json())
        .then(data => (this.items = data));
    }
  }
};
</script>
