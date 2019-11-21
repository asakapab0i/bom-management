<template>
  <card :title="$t('bom_productlist')">
  <div>
    <b-table
      :borderless="borderless"
      :items="data">
      <template v-slot:table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
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
      data : null,
      isBusy: false,
    }
  },
  created(){
    this.toggleBusy()
    fetch('/api/bom').then(response => response.json())
            .then((data) => this.data = data);
    this.toggleBusy()
  },
  methods: {
    toggleBusy() {
      this.isBusy = !this.isBusy
    }
  }
}
</script>
