<template>
  <card :title="$t('bom_add_product')">
    <form @submit.prevent="add_product" @keydown="form.onKeydown($event)">
      <!-- Product Name -->
      <b-form-group
        id="input-group-1"
        label="Product Name:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.product_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <!-- Product Quantity -->
      <b-form-group
        id="input-group-1"
        label="Product Quantity:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.product_quantity"
          type="number"
          required
        ></b-form-input>
      </b-form-group>

      <!-- Submit Button -->
      <div>
        <b-button
          type="submit"
          variant="outline-primary"
        >
            {{ $t('bom_add_product') }}
        </b-button>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('bom_add_product') }
  },

  data: () => ({
    form: new Form({
      product_name: '',
    })
  }),

  methods: {
    async add_product () {
      const { data } = await this.form.post('/api/bom/store')
      this.form.reset()
    }
  }
}
</script>
