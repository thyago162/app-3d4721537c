<template>
  <div>
    <b-modal
        id="form-stock"
        title="Balanço de estoque"
        no-close-on-esc
        no-close-on-backdrop
        hide-footer
        header-bg-variant="success"
        header-text-variant="light"
        hide-header-close
    >
      <h3>Sku: {{sku}}</h3>
      <validation-observer ref="observer" v-slot="{ handleSubmit }">
        <b-form @submit.stop.prevent="handleSubmit(updateStock())" class="mt-4">
          <validation-provider
              name="operation_type"
              :rules="{ required: true, min: 3, max: 250 }"
              v-slot="validationContext"
          >
            <b-form-group
                id="stock-operation_type-group"
                label="Tipo da operação"
            >
              <b-form-select
                  v-model="form.operation_type"
                  name="operation_type"
                  :state="getValidationState(validationContext)"
                  aria-describedby="stock-operation_type-feedback"
              >
                <b-form-select-option value="credit">Crédito</b-form-select-option>
                <b-form-select-option value="debit">Débito</b-form-select-option>
              </b-form-select>
              <b-form-invalid-feedback id="stock-operation_type-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <validation-provider
              name="operation_value"
              :rules="{ required: true}"
              v-slot="validationContext"
          >
            <b-form-group
                id="stock-operation_value-group"
                label="Valor"
            >
              <b-form-input
                  v-model="form.operation_value"
                  name="operation_value"
                  :state="getValidationState(validationContext)"
                  aria-describedby="stock-operation_value-feedback"
                  size="sm"
                  type="number"
                  min="0"
              >
              </b-form-input>
              <b-form-invalid-feedback id="stock-operation_value-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <div class="mt-4">
            <b-button variant="success" type="submit">Salvar</b-button>
            <b-button variant="danger" @click="fecharModal">Fechar</b-button>
          </div>
        </b-form>
      </validation-observer>

    </b-modal>
  </div>
</template>

<script>
export default {
  name: "FormStock",
  props: ['sku'],
  data() {
    return {
      form: {
        operation_type: '',
        operation_value: '',
      }
    }
  },

  methods: {
    updateStock() {
      this.$axios.put('http://localhost:8000/api/stock/' + this.sku, this.form)
      .then(() => {
        this.$fire({
          title: 'Sucesso',
          text: 'Operação realizada com sucesso',
          type: 'success'
        })
        this.$store.dispatch('products', {})
        this.$bvModal.hide('form-stock')
      }).catch(error => {
        this.$fire({
          title: 'Erro',
          text: 'Não foi possível completar a operação',
          type: 'danger'
        })
        this.$bvModal.hide('form-stock')
      })

    },
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },
    fecharModal() {
      this.$bvModal.hide('form-stock')
    }
  }
}
</script>

<style scoped>

</style>