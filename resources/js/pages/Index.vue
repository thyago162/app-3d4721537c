<template>
  <b-container>
    <b-row class="mt-5">
      <b-col>
        <h3>Produtos</h3>
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
                placeholder="Procurar por sku, nome">
            </b-form-input>
          </b-col>
          <b-col>
            <b-button size="sm" class="my-2 my-sm-0" @click="searchForProduct()">
              <b-icon-search></b-icon-search>
            </b-button>
          </b-col>
        </b-row>
      </b-col>
      <b-col offset-lg="4">
        <b-button variant="primary" v-b-modal.form-product>
          <b-icon-plus></b-icon-plus>
        </b-button>
        <b-button variant="danger" @click="removeProduct()">
          <b-icon-trash></b-icon-trash>
        </b-button>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-table :items="products.data" :fields="fields" striped>
          <template v-slot:cell(select)="row">
            <b-form-checkbox @change="selectProduct(row.item.id)"></b-form-checkbox>
          </template>
          <template v-slot:cell(actions)="row">
            <b-button size="sm" variant="success">
              <b-icon-box></b-icon-box>
            </b-button>
            <b-button size="sm" variant="info" @click="updateProduct(row.item)">
              <b-icon-pen></b-icon-pen>
            </b-button>
            <b-button size="sm" variant="danger" @click="removeOneProuduct(row.item.id)">
              <b-icon-trash></b-icon-trash>
            </b-button>
          </template>
        </b-table>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <label>Páginas</label>
        <b-form-select v-model="per_page" @change="searchForProduct()">
          <b-form-select-option value="5">5</b-form-select-option>
          <b-form-select-option value="10">10</b-form-select-option>
          <b-form-select-option value="20">20</b-form-select-option>
          <b-form-select-option value="30">30</b-form-select-option>
        </b-form-select>
      </b-col>
      <b-col>
        <b-pagination
            :perPage="products.per_page"
            v-model="current_page"
            aria-controls="product-table"
            :total-rows="products.total"
        ></b-pagination>
        {{ this.selected }}
      </b-col>
    </b-row>
    <FormProduct :product="product" nome="Thyago"/>
  </b-container>
</template>

<script>
import FormProduct from "../components/products/FormProduct";

export default {
  name: "index",
  components: {FormProduct},

  created() {
    this.$store.dispatch(
        'products',
        {"search": this.search, "per_page": this.per_page}
    )
  },

  data() {
    return {
      fields: [
        {label: '', key: 'select'},
        {label: 'Nome', key: 'name'},
        {label: 'Sku', key: 'sku'},
        {label: 'Estoque', key: 'initial_quantity'},
        {label: '', key: 'actions'},
      ],
      current_page: 1,
      search: '',
      per_page: '',
      selected: '',
      product_checked: [],
      product: {}
    }
  },
  computed: {
    products: function () {
      return this.$store.getters.getProduts
    }
  },

  methods: {
    searchForProduct() {
      this.$store.dispatch(
          'products',
          {"search": this.search, "per_page": this.per_page}
      )
    },
    selectProduct(id) {
      const found = this.product_checked.includes(id)
      if (found === false) {
        this.product_checked.push(id)
      }
      console.log(this.product_checked)
    },
    removeProduct() {
      this.$confirm('Tem certeza que deseja prosseguir?').then(() => {
        this.$axios.delete('http://localhost:8000/api/products/' + `${this.product_checked}`)
            .then(() => {
              this.$fire({
                title: 'Sucesso',
                text: 'Produto(s) removido com sucesso',
                type: 'success'
              })
              this.$store.dispatch('products', {"search": this.search, "per_page": this.per_page})
            })
            .catch(() => {
              this.$fire({
                title: 'Erro',
                text: 'Não foi possível remover o(s) produto',
                type: 'danger'
              })
            })
      })
    },
    removeOneProuduct(id) {
      const found = this.product_checked.includes(id)
      if (found === false) {
        this.product_checked.push(id)
      }
      this.removeProduct();
    },
    updateProduct(product) {
      this.product = product;
      this.$bvModal.show('form-product')
    }
  }


}
</script>
