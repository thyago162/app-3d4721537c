<template>
  <div>
    <b-modal
        id="form-product"
        title="Produto"
        no-close-on-esc
        no-close-on-backdrop
        hide-footer
        header-bg-variant="success"
        header-text-variant="light"
        hide-header-close
    >
      <validation-observer ref="observer" v-slot="{ handleSubmit }">
        <b-form @submit.stop.prevent="handleSubmit(save)">
          <validation-provider
              name="Name"
              :rules="{ required: true, min: 3, max: 250 }"
              v-slot="validationContext"
          >
            <b-form-group id="product-name-group" label="Nome">
              <b-form-input
                  id="product-name"
                  name="name"
                  v-model="form.name"
                  :state="getValidationState(validationContext)"
                  aria-describedby="product-name-feedback"
              ></b-form-input>

              <b-form-invalid-feedback id="product-name-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <validation-provider
              name="Sku"
              :rules="{ required: true, min: 3, max:10 }"
              v-slot="validationContext"
          >
            <b-form-group id="product-sku-group" label="Sku">
              <b-form-input
                  id="product-sku"
                  name="sku"
                  v-model="form.sku"
                  :state="getValidationState(validationContext)"
                  aria-describedby="product-sku-feedback"
              ></b-form-input>

              <b-form-invalid-feedback id="product-sku-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <validation-provider
              name="initial_quantity"
              :rules="{ required: true }"
              v-slot="validationContext"
          >
            <b-form-group id="product-initial_quantity-group" label="Quantidade inicial">
              <b-form-input
                  id="product-initial_quantity"
                  name="initial_quantity"
                  v-model="form.initial_quantity"
                  :state="getValidationState(validationContext)"
                  aria-describedby="product-initial_quantity-feedback"
                  type="number"
                  min="0"
              ></b-form-input>

              <b-form-invalid-feedback id="product-initial_quantity-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <validation-provider
              name="price"
              :rules="{ required: true}"
              v-slot="validationContext"
          >
            <b-form-group id="product-price-group" label="Preço">
              <b-form-input
                  id="product-price"
                  name="price"
                  v-model="form.price"
                  :state="getValidationState(validationContext)"
                  aria-describedby="product-price-feedback"
              ></b-form-input>

              <b-form-invalid-feedback id="product-price-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>
          <div class="mt-4">
            <b-button variant="success" type="submit">Salvar</b-button>
            <b-button variant="danger" @click="fecharModal">Fechar</b-button>
          </div>
        </b-form>
      </validation-observer>
      <input type="hidden" :value="product" />
    </b-modal>
  </div>
</template>

<script>


export default {
  name: "FormProduct",
  props: ['product', 'nome'],
  data() {
    return {
      form: {
        id: '',
        name: '',
        sku: '',
        initial_quantity: '',
        price: ''
      },
      errors: []
    }
  },
  beforeUpdate() {
    if (this.product) {
      for (const key in this.product) {
        this.form[key] = this.product[key]
      }
    }
  },
  methods: {
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },
    save() {
      this.$axios.post('http://localhost:8000/api/products', this.form)
      .then(() => {
        this.$store.dispatch('products', {})
        this.$fire({
          title: "Sucesso",
          text: "Produto salvo com sucesso",
          type: "success"
        }).then(() => {
          this.$bvModal.hide('form-product')
        })
      })
      .catch(error => {
        if (error.response.status === 422) {
          this.$refs.observer.setErrors(error.response.data.errors)
        }
        this.$fire({
          title: "Erro",
          type: "danger"
        })
      })

    },
    fecharModal() {
      this.$bvModal.hide('form-product')
    }
  }
}
</script>

<style scoped>

</style>