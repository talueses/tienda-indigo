<template>
  <div class="table-responsive">
    <p v-show="cart.products && !cart.products.length">
      Tu carrito está vacio.
    </p>
    <table
      v-show="cart.products && cart.products.length"
      class="table"
      width="100%"
      cellspacing="0"
    >
      <thead>
        <tr>
          <th class="align-middle text-center">Producto</th>
          <th class="align-middle text-center">Descripción</th>
          <!--th class="align-middle text-center">Disponibilidad</th-->
          <th class="align-middle text-center">Precio Unitario</th>
          <th class="align-middle text-center">Cantidad</th>
          <th></th>
          <th class="align-middle text-center">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(row, index) in cart.products"
          v-bind:key="index"
          v-bind:class="{ error: row.error, errorstock: row.stock == 0 }"
        >
          <td width="120" class="cart_product">
            <img
              class="img-fluid img-list-default"
              alt=""
              v-bind:src="
                row.img ? '/uploads/products/' + row.img : '/media/default.jpg'
              "
            />
          </td>
          <td class="align-middle text-center">
            <p class="product-name m-0">
              <a v-bind:href="'/producto/' + row.slug">
                {{ row.name }}
                <span v-if="row.color"> - {{ jsUcfirst(row.color) }}</span>
              </a>

              <template v-if="row.wedding_list_id">
                <br /><a
                  v-bind:href="
                    'programa-de-regalos/lista?codigo=' + row.wedding_list_id
                  "
                  ><span class="badge badge-danger"
                    >Lista: {{ row.wedding_list_id }}</span
                  ></a
                >
                <br /><span v-if="row.recargo" class="badge badge-info">
                  Este producto tiene un recargo por delivery
                </span>
              </template>

              <template v-if="row.error">
                <br />
                <small
                  v-if="row.error_msg"
                  class="product-error text-danger font-weight-bold"
                  >{{ row.error_msg }}</small
                >
                <small v-else class="product-error text-danger font-weight-bold"
                  >* La cantidad solicitada no esta disponible</small
                >
              </template>

              <template v-if="row.stock == 0">
                <br /><small class="product-error text-danger font-weight-bold"
                  >* No hay stock disponible</small
                >
              </template>
            </p>
          </td>
          <td class="align-middle text-center">
            <!--template v-if="row.old_price">
                          <span class="linethrough">S/. {{ row.old_price }} </span>
                          <br>
                        </templat-->

            <span class="unit_price" v-if="row.dsct != 0">
              <strike> S/ {{ formatUnitPrice(row.price) }} </strike></span
            ><br />
            <span class="unit_price" v-if="row.dsct == 0">
              S/ {{ formatUnitPrice(row.price) }}</span
            >
            <span class="unit_price" v-if="row.dsct != 0" style="color:red">
              - S/ {{ formatUnitPrice(row.dsct) }} </span
            ><br />
            <span class="unit_price" v-if="row.dsct != 0" style="color:green"
              ><strong
                >S/ {{ formatUnitPrice(row.price - row.dsct) }}
              </strong></span
            >
          </td>
          <td class="align-middle text-center">
            <input name="quantity" type="hidden" v-model="row.quantity" />

            <!--template v-if="row.wedding_list_id">
                            <span>{{row.quantity}}</span>
                        </template-->

            <template>
              <input
                v-on:keyup="updateQuantity(index, $event, row)"
                size="2"
                autocomplete="off"
                class="cart_quantity_input form-control"
                v-model="row.quantity"
                pattern="[0-9]*"
                type="text"
                min="1"
                :disabled="row.stock == 0"
              />
            </template>

            <div class="cart_quantity_button clearfix"></div>
          </td>
          <td class="align-middle text-center">
            <span
              v-on:click="removeElement(index, row, $event)"
              class="cart_quantity_delete"
            >
              <i class="fas fa-trash-alt"></i
            ></span>
          </td>
          <td class="align-middle text-center">
            <span id="total_product_price_ID_COLOR" class="total_product_price">
              S/ {{ ((row.price - row.dsct) * row.quantity).toFixed(2) }}
            </span>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3"></td>
          <td colspan="2" class="total_price_container text-right">
            <b>Subtotal</b>
          </td>
          <td
            colspan="1"
            class="price align-middle text-center"
            id="total_price_container"
          >
            <span id="total_price">S/ {{ getSubTotal() }}</span>
          </td>
        </tr>
        <tr>
          <td colspan="3"></td>
          <td colspan="2" class="total_price_container text-right">
            <b>Costo de envío</b>
          </td>
          <td
            colspan="1"
            class="price align-middle text-center"
            id="total_price_container"
          >
            <span id="total_price">{{ getShippingPrice() }}</span>
          </td>
        </tr>
        <tr class="cart_total_price">
          <td colspan="3"></td>
          <td colspan="2" class="total_price_container text-right">
            <b>Total</b>
          </td>
          <td
            colspan="1"
            class="price align-middle text-center"
            id="total_price_container"
          >
            S/ <span id="total_price1">{{ getTotal() }}</span>
          </td>
        </tr>
      </tfoot>
    </table>
    <button
      class="continue btn btn-outline-secondary linear"
      title="Seguir comprando"
      @click="goToShopping()"
    >
      <span> <i class="icon-chevron-left left"></i>Seguir comprando </span>
    </button>
  </div>
</template>


<script>
const Cart = require("./Cart");
export default {
 
  props: ["cart", "cartSubTotal", "shippingPrice", "cartTotal"],
  data() {
    return {};
  },
  methods: {
    goToShopping() {
      window.location.replace("tienda");
    },
    updateQuantity(index, event, row) {
      event.preventDefault();

      let regNumbers = new RegExp("^[0-9]+$");
      if (!regNumbers.test(row.quantity) || isNaN(row.quantity)) {
        return;
      }

      var product = {
        id: row.id,
        color: row.color ? row.color : "",
        wedding_list_id: row.wedding_list_id ? row.wedding_list_id : "",
      };

      Cart.updateProduct(product, row.quantity);

      this.$emit("update");
    },
    removeElement(index, row, event) {
      event.preventDefault();

      var product = {
        id: row.id,
        color: row.color ? row.color : "",
        wedding_list_id: row.wedding_list_id ? row.wedding_list_id : "",
      };

      Cart.deleteProduct(product);
      this.cart.products.splice(index, 1);

      this.$emit("update");
    },
    formatUnitPrice(amount) {
      let finalAmount = Number(amount);
      return finalAmount.toFixed(2);
    },
    getShippingPrice() {
      if (!isNaN(this.shippingPrice)) {
        return "S/ " + this.shippingPrice;
      }
      return this.shippingPrice;
    },
    getSubTotal() {
      return this.cartSubTotal;
    },
    getTotal() {
      var totalPagar = this;
      return this.cartTotal;
    },
    jsUcfirst(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
  },
};
</script>

<style>
.pagar {
  background-color: #5c116e;
  color: white;
}
.error {
  background-color: #fad8da66;
}
.errorstock {
  background-color: #cecece;
}
</style>
