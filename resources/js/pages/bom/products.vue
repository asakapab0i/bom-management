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
          <b-button size="sm" v-b-modal="'product-modal' + row.item.id">Show Details</b-button>
          <!-- The modal -->
          <b-modal :id="'product-modal' + row.item.id" title="Update Product">
            <b-form @submit.prevent="update_product">
              <!-- Product Name -->
              <b-form-group id="input-group-1" label="Product Name:" label-for="input-1">
                <b-form-input id="input-1" v-model="form.product_name" type="text" required></b-form-input>
              </b-form-group>
              <!-- Product Quantity -->
              <b-form-group id="input-group-1" label="Product Quantity:" label-for="input-1">
                <b-form-input id="input-1" v-model="form.product_quantity" type="number" required></b-form-input>
              </b-form-group>
            </b-form>
            <template v-slot:modal-footer="{ ok, cancel, hide }">
              <b-button size="sm" variant="outline-success" @click="hide('forget')">Approve</b-button>
              <b-button size="sm" variant="success" @click="ok()">Update</b-button>
              <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
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
  data() {
    return {
      form: function() {
        return new Form({
          product_name: ""
        });
      },
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
      isBusy: true
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
    }
  }
};
</script>
