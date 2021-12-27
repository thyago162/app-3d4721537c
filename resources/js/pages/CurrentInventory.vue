<template>
  <b-container>
    <b-row class="mt-5">
      <b-col>
        <h3>Movimentação do estoque</h3>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-row>
          <b-col>
            <b-form-input
                v-model="search"
                size="sm"
                class="mr-sm-2"
                placeholder="Procurar por sku">
            </b-form-input>
          </b-col>
          <b-col>
            <b-button size="sm" class="my-2 my-sm-0" @click="searchForInventory()">
              <b-icon-search></b-icon-search>
            </b-button>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table :items="stock_balance.data" :fields="fields" striped>
        </b-table>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <label>Páginas</label>
        <b-form-select v-model="per_page" @change="searchForInventory()">
          <b-form-select-option value="5">5</b-form-select-option>
          <b-form-select-option value="10">10</b-form-select-option>
          <b-form-select-option value="20">20</b-form-select-option>
          <b-form-select-option value="30">30</b-form-select-option>
        </b-form-select>
      </b-col>
      <b-col>
        <b-pagination
            :perPage="stock_balance.per_page"
            v-model="current_page"
            aria-controls="product-table"
            :total-rows="stock_balance.total"
        ></b-pagination>
        {{ this.selected }}
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  name: "CurrentInventory",
  data() {
    return {
      stock_balance: [],
      per_page: '',
      current_page: 1,
      search: '',
      fields: [
        {label: 'Tipo da operação', key: 'operation_type'},
        {label: 'Valor da operação', key: 'operation_value'},
        {label: 'Saldo anterior', key: 'previous_balance'},
        {label: 'Estoque atual', key: 'product.initial_quantity'},
        {label: 'Sku', key: 'product.sku'},
        {label: 'Data', key: 'created_at'}

      ],
    }
  },
  created() {
    this.searchForInventory()
  },
  methods: {
    searchForInventory() {
      this.$axios.get('http://localhost:8000/api/stock-balance', {
        params: {
          "per_page": this.per_page,
          "search": this.search
        }
      })
      .then(response => {
        this.stock_balance = response.data.stock_balance
      })
      .catch(error => {
        this.$fire({
          title: 'Opa!',
          text: error.response.data.error,
          type: 'error'
        })
      })

    }
  }
}
</script>

<style scoped>

</style>