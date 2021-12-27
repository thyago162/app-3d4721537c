import Product from '../pages/Product'
import CurrentInventory from "../pages/CurrentInventory";

export default [
    {
        path: '/',
        component: Product,
    },
    {
        path: '/movimentacao-estoque',
        component: CurrentInventory
    }
]