<template>
  <div class="table-responsive">
    <p v-show="cart.products && !cart.products.length">
        No se ha agregado ningún producto a tu lista.
    </p>
    <table v-show="cart.products && cart.products.length" class="table" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th></th>
          <th class="align-middle text-center"> Regalo </th>
          <th class="align-middle text-center"> Color </th>
          <th class="align-middle text-center"> Solicitados </th>
          <th class="align-middle text-center"> Recibidos </th>
          <th class="align-middle text-center"> Precio Unitario </th>
          <th class="align-middle text-center"> Recargo por delivery </th>
          <th class="align-middle text-center"> Total </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in cart.products" v-bind:key="index" v-bind:class="{ error: row.error, errorstock: row.stock == 0 }">

          <td class="pt-1 pb-1 pl-2 cart_product">
              <img class='img-fluid img-list-default' alt='' v-bind:src="(row.img) ? '/uploads/products/'+row.img : '/media/default.jpg'">
          </td>

          <td class="align-middle text-center">
            {{ row.name }}
            <template v-if="row.error">
              <br>
              <small v-if="row.error_msg" class="product-error text-danger font-weight-bold">{{ row.error_msg }}</small>
              <small v-else class="product-error text-danger font-weight-bold">* La cantidad solicitada no esta disponible</small>
            </template>

            <template v-if="row.stock == 0">
              <br><small class="product-error text-danger font-weight-bold">* No hay stock disponible</small>
            </template>
          </td>

          <td class="align-middle text-center">
              <span v-if="row.color"> {{ jsUcfirst(row.color) }} </span>
          </td>

          <td class="align-middle text-center">
              <input name='quantity' type='hidden' v-model="row.quantity">

              <template ref="quantityContainer">
                <input v-on:change="updateQuantity(index, $event, row)" :disabled="row.stock == 0 || list.edicion_finalizada == 1" class="cart_quantity_input form-control" type="number"  min="1" v-model="row.quantity" pattern='[0-9]*' autocomplete="off">
              </template>

              <div class='cart_quantity_button clearfix'></div>
          </td>

          <td class="align-middle text-center">
              
              <span> {{ row.recibidos }} </span>
          </td>

          <td class="align-middle text-center">
              <br>
              <template v-if="row.dsct_lista_regalo <= 0">
                <span class='unit_price'> S/. {{ formatUnitPrice(row.price) }} </span>
              </template>

              <template v-if="row.dsct_lista_regalo > 0">
                <span class='old_price'> S/. {{ formatUnitPrice(row.price) }} </span>
                <br>
                <span class='product-dsct'> S/. {{ formatUnitPrice(row.price) - formatUnitPrice(row.dsct_lista_regalo) }} </span>
              </template>
          </td>

          <td class="align-middle text-center">
              <span class='unit_price'> S/. {{ formatUnitPrice(row.recargo) }} </span>
          </td>

          <td class="align-middle text-center">
              <span id="total_product_price_ID_COLOR" class="total_product_price">
                  S/. {{ calcTotalGiftItem(row) }}
              </span>
          </td>

          <td class="align-middle text-center">
              <span v-on:click="removeElement(index, row, $event )" class="cart_quantity_delete"> <i class="fas fa-trash-alt text-warning"></i></span>
          </td>

        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

    export default {
        props: ['cart', 'list'],
        data() {
            return {
              products : {}
            }
        },
        methods: {
            updateQuantity(index, event, row) {

                event.preventDefault();
                var vm = this

                let regNumbers = new RegExp('^[0-9]+$')

                if (!regNumbers.test(row.quantity)||isNaN(row.quantity)) {
                  row.quantity = 1
                  return
                }

                var loader = this.$loading.show({container: vm.$refs.quantityContainer })

                axios.post('/api/giftproduct/update', { product_id: row.id, gift_list_id: vm.list.id, quantity: row.quantity }).then(function (response) 
                {
                    if(!response.data) 
                    {
                      console.log('El producto no pudo ser actualizado')
                    } else {

                      vm.$notify({
                          group: 'notifications',
                          title: 'Actualización',
                          text: 'Cantidad modificada correctamente'
                      })

                      loader.hide()

                      vm.$emit('update')
                    }
                    
                })
                .catch(function (error) {
                    console.log('ERROR: al actualizar el producto')
                    console.log(error)
                })
  
            },
            removeElement(index, row, event) {
    
                event.preventDefault();
                var vm = this
    
                axios.post('/api/giftproduct/remove', { product_id: row.id, gift_list_id: vm.list.id }).then(function (response) 
                {
                    if(response.data) 
                    {
                      vm.cart.products.splice(index, 1)
                      vm.$emit('update')
                      vm.$notify({
                          group: 'notifications',
                          title: 'Eliminado',
                          text: 'El producto ha sido eliminado correctamente de la lista de regalos'
                      })
                    } else 
                    {
                      console.log('El producto no pudo ser eliminado')
                    }
                    
                })
                .catch(function (error) {
                    console.log('ERROR: al eliminar el producto')
                    console.log(error)
                })

            },
            formatUnitPrice(amount) 
            {
              let finalAmount = Number(amount)
              return finalAmount.toFixed(2)
            },
            jsUcfirst(string) 
            {
              return string.charAt(0).toUpperCase() + string.slice(1)
            },
            calcTotalGiftItem(row) 
            {
                let newPrice = ((row.price - row.dsct_lista_regalo) + (row.recargo / row.quantity)) * row.quantity
                return newPrice.toFixed(2)
            }
        }
    }
</script>

<style>
.error {
  background-color:#fad8da66;
}
.errorstock {
  background-color:#cecece;
}
.old_price {
  text-decoration: line-through;color: gray;
}
input[type="number"] {
   min-width: 70px;
   height:35px
}
</style>
