<template>
  <card :title="$t('bom_add_product')">
    <form @submit.prevent="add_product" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('bom_add_product_name_success')" />

      <!-- Name -->
      <div class="form-group row">
        <label class="col-md-3 col-form-label text-md-right">{{ $t('bom_add_product_name') }}</label>
        <div class="col-md-7">
          <input v-model="form.product_name" :class="{ 'is-invalid': form.errors.has('product_name') }" class="form-control" type="text" name="product_name">
          <has-error :form="form" field="product_name" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="form-group row">
        <div class="col-md-9 ml-md-auto">
          <v-button :loading="form.busy" type="primary">
            {{ $t('bom_add_product') }}
          </v-button>
        </div>
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
