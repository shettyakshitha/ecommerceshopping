const products = [
  { id: 0, image: 'images/babygir2.jpeg', title: 'Cotton gauze set', price: 120 },
  { id: 1, image: 'images/babygir7.jpeg', title: 'baby dress', price: 220 },
  { id: 2, image: 'images/boy7.jpg', title: 'summer dress', price: 230 },
  { id: 3, image: 'images/girl9.jpeg', title: 'sweatsuit for men', price: 100 },
];


const categories = [...new Set(products.map(item => item.title))];

// products.map(item => item.title) extracts just the titles of each product in the products array.

// Remove Duplicates: new Set(...) creates a set, which automatically removes duplicates from the array of titles.

// Convert Set to Array: [...new Set(...)] spreads the unique titles back into an array.

const rootElement = document.getElementById('root');
const cartElement = document.getElementById('cartItem');
const totalElement = document.getElementById('total');
const countElement = document.getElementById('count');
const cart = [];

function renderProduct(product) {
  return `
      <div class='box'>
          <div class='img-box'>
              <img class='images' src='${product.image}' alt='${product.title}'>
          </div>
          <div class='bottom'>
              <p>${product.title}</p>
              <h2>$ ${product.price}.00</h2>
              <button onclick='addToCart(${product.id})'>Add to cart</button>
          </div>
      </div>
  `;
}

function renderCartItem(item, index) {
  return `
      <div class='cart-item'>
          <div class='row-img'>
              <img class='rowimg' src='${item.image}' alt='${item.title}'>
          </div>
          <p style='font-size:12px;'>${item.title}</p>
          <h2 style='font-size: 15px;'>$ ${item.price}.00</h2>
          <i class='fa-solid fa-trash' onclick='deleteElement(${index})'></i>
      </div>
  `;
}

function addToCart(productId) {
  const selectedProduct = products.find(product => product.id === productId);
  if (selectedProduct) {
      cart.push({ ...selectedProduct });
      displayCart();
  }
}

function deleteElement(index) {
  cart.splice(index, 1);
  displayCart();
}

function displayCart() {
  let total = 0;
  countElement.textContent = cart.length;

  if (cart.length === 0) {
      cartElement.textContent = 'Your cart is empty';
      totalElement.textContent = '$ 0.00';
  } else {
      cartElement.innerHTML = cart.map(renderCartItem).join('');
      total = cart.reduce((acc, item) => acc + item.price, 0);
      totalElement.textContent = `$ ${total}.00`;
  }
}

function proceedToPay() {
  alert('Proceed to pay');
}

rootElement.innerHTML = categories.map(category => {
  const product = products.find(item => item.title === category);
  return renderProduct(product);
}).join('');
