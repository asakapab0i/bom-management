<template>
  <card title="Add Hardware">
    <b-alert
              variant="success"
              dismissible
              :show="showAlert"
              @dismissed="showAlert=false"
            >Hardware has been added!</b-alert>
    <form @submit.prevent="add_hardware" @keydown="form.onKeydown($event)">
      <!-- Product Name -->
      <b-form-group
        id="input-group-1"
        label="Hardware Name:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.hardware_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <!-- Product Quantity -->
      <b-form-group
        id="input-group-1"
        label="Hardware Quantity:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.hardware_quantity"
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
            Add Hardware
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
    return { title: "Add Hardware" }
  },

  data: () => ({
    showAlert: false,
    form: new Form({
    })
  }),

  methods: {
    async add_hardware () {
      const { data } = await this.form.post('/api/hardware')
      this.showAlert = true
      this.form.reset()
    }
  }
}
</script>
