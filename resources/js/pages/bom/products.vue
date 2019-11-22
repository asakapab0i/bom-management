<template>
  <card :title="$t('bom_productlist')">
  <div>
    <b-table
      borderless
      :items="items"
      :fields="fields"
      :busy="isBusy"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc">
      <template v-slot:cell(show_details)="row">
        <b-button size="sm" class="mr-2">
          Show Details
        </b-button>
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
  middleware: 'auth',
  computed: {
    add_product (){
      return {
        name: "Add Product",
        route: "bom.add_product"
      }
    }
  },
  data(){
    return {
      sortBy: 'created_at',
      sortDesc: true,
      fields: [
        { key: 'productName', sortable: true },
        { key: 'productQuantity', sortable: true },
        { key: 'productStatus', sortable: true },
        { key: 'created_at', sortable: true }
      ],
      items : null,
      isBusy: true,
    }
  },
  created(){
    this.toggleBusy()
    fetch('/api/bom').then(response => response.json())
            .then((data) => this.items = data);
    this.toggleBusy()
  },
  updated(){
    this.isBusy = false;
  },
  methods: {
    toggleBusy() {
      this.isBusy = !this.isBusy
    }
  }
}
</script>
