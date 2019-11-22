<template>
  <card :title="$t('bom_productlist')">
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
          <b-modal :id="'product-modal' + row.item.id" title="Update Product">
            <b-alert
              variant="success"
              dismissible
              :show="showAlert"
              @dismissed="showAlert=false"
            >Product updated!</b-alert>
            <b-form @submit.prevent="update_product(row.item.id)">
              <!-- Product Name -->
              <b-form-group id="input-group-1" label="Product Name:" label-for="input-1">
                <div v-if="product">
                  <b-form-input id="input-1" v-model="product[0].productName" type="text" required></b-form-input>
                </div>
              </b-form-group>
              <!-- Product Quantity -->
              <b-form-group id="input-group-1" label="Product Quantity:" label-for="input-1">
                <div v-if="product">
                  <b-form-input @change="changeQty" id="input-1" v-model="product[0].productQuantity" type="number"></b-form-input>
                </div>
              </b-form-group>
              <div class="form-row material-input">
                <!-- Material Name -->
                <b-form-group class="col-md-6" id="input-group-1" label="Material Name:" label-for="input-1">
                  <div v-if="materials">
                    <b-form-select v-model="product[0].material" :options="materials"></b-form-select>
                  </div>
                </b-form-group>
                <!-- Material Quantity -->
                <b-form-group class="col-md-6" id="input-group-1" label="Material Quantity:" label-for="input-1">
                  <div v-if="product">
                    <b-form-input v-model="product[0].materialQuantity" id="input-1" type="number"></b-form-input>
                  </div>
                </b-form-group>
              </div>
              <div class="form-row hardware-input">
                <!-- Hardware Name -->
                <b-form-group class="col-md-6" id="input-group-1" label="Hardware Name:" label-for="input-1">
                  <div v-if="hardwares">
                    <b-form-select v-model="product[0].hardware" :options="hardwares"></b-form-select>
                  </div>
                </b-form-group>
                <!-- Hardware Quantity -->
                <b-form-group class="col-md-6" id="input-group-1" label="Hardware Quantity:" label-for="input-1">
                  <div v-if="product">
                    <b-form-input v-model="product[0].hardwareQuantity" id="input-1" type="number"></b-form-input>
                  </div>
                </b-form-group>
              </div>
              <b-button :disabled="product[0].productStatus == 'Approved'" size="sm" variant="success" type="submit">Update</b-button>
            </b-form>
            <template v-slot:modal-footer="{ ok, cancel, hide }">
              <b-button :disabled="product[0].productStatus == 'Approved'" size="sm" variant="outline-success" @click="handle_approval(row.item.id)">Approve</b-button>
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
      <router-link :to="{ name: add_product.route }">
        <b-button variant="outline-primary">{{ $t('bom_add_product') }}</b-button>
      </router-link>
    </div>
  </card>
</template>

<script>
export default {
  middleware: "auth",
  computed: {
    add_product() {
      return {
        name: "Add Product",
        route: "bom.add_product"
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
        { key: "productName", sortable: true },
        { key: "productQuantity", sortable: true },
        { key: "productStatus", sortable: true },
        { key: "created_at", sortable: true },
        { key: "show_details", sortable: true }
      ],
      items: null,
      isBusy: true,
      product: null,
      hardwares: null,
      materials: null,
    };
  },
  created() {
    this.toggleBusy();
    fetch("/api/bom")
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
    get_hardwares(){
       fetch("/api/hardware_categories/")
        .then(response => response.json())
        .then(data => (this.hardwares = data));
    },
    get_materials(){
       fetch("/api/material_categories/")
        .then(response => response.json())
        .then(data => (this.materials = data));
    },
    get_product(id) {
      this.get_materials()
      this.get_hardwares()
      fetch("/api/bom/" + id)
        .then(response => response.json())
        .then(data => (this.product = data));
    },
    update_product(id) {
      this.$http.post("/api/bom/" + id, this.product, function(data) {});
      this.showAlert = true;
    },
    refresh_products() {
      this.isBusy = true;
      fetch("/api/bom")
        .then(response => response.json())
        .then(data => (this.items = data));
    },
    changeQty(){
      if(this.product[0].productQuantity > 1){
        this.product[0].hardwareQuantity = this.product[0].hardwareQuantity * this.product[0].productQuantity
        this.product[0].materialQuantity = this.product[0].materialQuantity * this.product[0].productQuantity
      }
    },
    handle_approval(id){
      this.$http.post("/api/bom/approve/" + id, this.product, function(data) {});
    }
  }
};
</script>
