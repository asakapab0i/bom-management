<template>
  <card :title="$t('bom_productlist')">
  <div>
    <b-table
      :items="items"
      :fields="fields">
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
      fields: ['productName', 'productQuantity', 'productStatus', 'created_at'],
      items : null,
      isBusy: false,
    }
  },
  created(){
    this.toggleBusy()
    fetch('/api/bom').then(response => response.json())
            .then((data) => this.items = data);
    this.toggleBusy()
  },
  methods: {
    toggleBusy() {
      this.isBusy = !this.isBusy
    }
  }
}
</script>
