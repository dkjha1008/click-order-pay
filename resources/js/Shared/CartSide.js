import React, { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import Moment from 'moment';
// import 'react-toastify/dist/ReactToastify.css';


//import usePlacesAutocomplete, { getGeocode, getLatLng } from 'use-places-autocomplete';
//import useOnclickOutside from 'react-cool-onclickoutside';
//import { debounce } from "debounce";

import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';
import LoadingButton from '@/Shared/LoadingButton';

export default ({cartOpened, handleClick, showModal, setCartPopup}) => {
	const { props } = usePage();
	const { auth, errors, app } = props;
	const [paymentPage, setPaymentPage] = useState(false);
	const [sending, setSending] = useState(false);
	
	const [cartData, setCartData] = useState([]);
	const [relatedProducts, setRelatedProducts] = useState([]);
	const [currentDate, setCurrentDate] = useState([]);
	const [months, setMonths] = useState([]);
	const [years, setYears] = useState([]);
	const [savedCard, setSavedCard] = useState({});
	
	const [tip, setTip] = useState(1);
	const [customTip, setCustomTip] = useState(false);
	const [payAmount, setPayAmount] = useState(0);
	const [cartCount, setCartCount] = useState(0);
	const [discountAmount, setDiscountAmount] = useState(0);
	
	const [tax, taxAmount] = useState(0);
	const [deliveryCharges, setDeliveryCharges] = useState(0);
	
	const [paymentType, setPaymentType] = useState('creditcard');
	
	const [discount, setDiscount] = useState({});	
	const current = route().current();
	
	let totalPrice = 0;
	
	const [values, setValues] = useState({
		name: '',
		phone_number: '',
		address: '',
		notes: '',
		card_name: '',
		card_number: '',
		cvv: '',
		expire_month: '',
		expire_year: '',
		tip: '1',
		promo_code: '',
		uuid: '',
		pay_amount: '',
		billing_address: '',
		city: '',
		state: '',
		zip_code: '',
		email:'',
		pickup_time:'',
		pickup_date:''
	});
	
	useEffect(() => {
		console.log("Testing");
		fetchCartData();
		if(cartOpened){
			fetchCartData();
		}
		//..delivery_charges
		setDeliveryCharges(app.settings.delivery_charges);
		console.log(cartData)
		//debugger;
	}, [cartOpened]);
	

	//FETCH DATA 

	async function fetchCartData() {
		var date = Date('Y-m-d');
		date = Moment(date).format('YYYY-MM-DD')
		setCurrentDate(date);

		try {
			let uuid = localStorage.getItem("uuid");
			let data = { uuid };
			await axios.get(route('cart.data', data)).then(res => {
				
				setCartData(res.data.data.cart_product);
				console.log("datajhjjhjhjhjhjhjhjhjhjhj",res.data.data.cart_product);
				setRelatedProducts(res.data.data.cart_product)
				setCartCount(res.data.count);
				setRelatedProducts(res.data.relatedProducts);
				console.log(relatedProducts);
				
				setMonths(res.data.months);
				setYears(res.data.years);
				setSavedCard(res.data.card);
				
				//...tax
				let newTax = res.data.price * app.settings.store_tax / 100;
				taxAmount(newTax.toFixed(2));
				
				//..set total price
				setPayAmount(parseFloat(res.data.price) + parseFloat(tip) + parseFloat(newTax) + parseFloat(deliveryCharges));
				
				if(current=='ucla'){
					setCartPopup(res.data.count, res.data.price);
				}
				
				if(res.data.auth && res.data.auth.phone_number){
					setValues(values => ({
						...values,
						name: res.data.auth.name,
						phone_number: res.data.auth.phone_number,
						email: res.data.auth.email,
						notes: res.data.auth.notes,
					}));
				}
	
			});
			setPaymentPage(false);
		} catch (error) {
			setCartData([]);
		}
	}
	
	function handleAction(type, product, cart) {
		let uuid = localStorage.getItem("uuid");
		let data = {type, product, cart, uuid}
		axios.post(route('cart.action'), data).then(res => {
			setCartData(res.data.data.cart_product);
			setCartCount(res.data.count);
			
			if(current=='ucla'){
				setCartPopup(res.data.count, res.data.price);
			}
			
			//...tax
			let newTax = res.data.price * app.settings.store_tax / 100;
			taxAmount(newTax.toFixed(2));
			
			//..set total price
			setPayAmount(parseFloat(res.data.price) + parseFloat(tip) + parseFloat(newTax) + parseFloat(deliveryCharges) - discountAmount);
			
			//setTip(0);
			if(res.data.count==0){
				const url = route('ucla');
				window.location.href = url;
			}
		});
	}

	function addToCart(product,store_id) {

		// setProductPopup({});
		let uuid = localStorage.getItem("uuid");
		
		let data = { uuid, product,store_id };
		axios.post(route('cart.store'), data).then(res => {
			setCartCount(res.data.count);
			toast(res.data.message);
			fetchCartData();
			
			// setCartPrice(res.data.price.toFixed(2));
		});
	}
	
	
	function addTip(tip){
		setTip(tip);
		
		setValues(values => ({
			...values,
			tip: tip
		}));
		setCustomTip(false);
		
		//..set total price
		setPayAmount(parseFloat(totalPrice) + parseFloat(tip) + parseFloat(tax) + parseFloat(deliveryCharges) - discountAmount);
	}

	
	function handleChange(e) {
		//debugger;
		const key = e.target.name;
		const value =
		e.target.type === 'checkbox' ? e.target.checked : e.target.value;
		
		if(key=='tip'){
			let newvalue = parseFloat(value);
			if(newvalue){
				newvalue = newvalue.replace(/^0+/, '');
				newvalue = 0;
			}
			else {
				newvalue = 0;
			}
			setTip(newvalue);
			//..set total price
			setPayAmount(parseFloat(totalPrice) + parseFloat(newvalue) + parseFloat(tax) + parseFloat(deliveryCharges) - discountAmount);
		}
		setValues(values => ({
			...values,
			[key]: value
		}));
		console.log(values)
	}
	
	function useCard(card){
		setValues(values => ({
			...values,
			card_name: card.card_name,
			card_number: card.card_number,
			expire_month: card.expire_month,
			expire_year: card.expire_year,
			zip_code: auth.user.zip_code,
		}));
	}
	
	
	function handleSubmit(e) {
		e.preventDefault();
		setSending(true);
		let uuid = localStorage.getItem("uuid");
		
		values['pay_amount'] = parseFloat(payAmount).toFixed(2);
		values['totalPrice'] = parseFloat(totalPrice).toFixed(2);
		values['tax'] = tax;
		values['delivery_charges'] = deliveryCharges;
		values['uuid'] = uuid;
		
		if(!paymentPage){
			axios.post(route('checkout.user'), values).then((res) => {
				if(res.data.type=='success'){					
					setPaymentPage(true);
				}
				else {
					toast(res.data.message);
				}
				setSending(false);
			});
		}
		
		if(paymentPage){
			if(paymentType=='venmo'){
				Inertia.post(route('checkout.venmo'), values).then(() => {
					setSending(false);
				});
			}
			else {
				Inertia.post(route('checkout.store'), values).then(() => {
					setSending(false);
				});
			}
		}
	}
	

	
	function checkPromoCode(){
		setSending(false);
		axios.post(route('promocode'), {promo_code: values.promo_code}).then((res) => {
			setSending(false);
			toast(res.data.message);
			if(res.data.type=='success'){
				setDiscount(res.data.code);
				let amount = 0;
				let discount_amount = 0;
				
				if(res.data.code.coupon_type=='percentage'){
					discount_amount = payAmount * res.data.code.discount / 100;
					amount = payAmount - discount_amount;
				}
				if(res.data.code.coupon_type=='fixed'){
					discount_amount = res.data.code.discount;
					amount = payAmount - discount_amount;
				}
				
				//...
				setDiscountAmount(discount_amount);
				setPayAmount(amount);
				//...tax
				//let newTax = res.data.price * app.settings.store_tax / 100;
				//taxAmount(newTax.toFixed(2));
				
				//..set total price
				//setPayAmount(parseFloat(res.data.price) + parseFloat(tip) + parseFloat(tax) + parseFloat(deliveryCharges)  - discount_amount);
			
			}
			if(res.data.type=='error'){
				setValues(values => ({
					...values,
					'promo_code': ''
				}));
				setDiscount({});
				setDiscountAmount(0);
				setPayAmount(parseFloat(totalPrice) + parseFloat(tip) + parseFloat(tax) + parseFloat(deliveryCharges));
			}
		});	
	}
	
	function removePromoCode(){
		setValues(values => ({
			...values,
			'promo_code': ''
		}));
		setDiscount({});
		setDiscountAmount(0);
		setPayAmount(parseFloat(totalPrice) + parseFloat(tip) + parseFloat(tax) + parseFloat(deliveryCharges));
	}
	
	function checkAuth(){
		if(!auth.user){
			showModal('login');
		}
	}
	
	
	return (
		<div id="sidebar" className={`${cartOpened ? 'active' : ''}`}>
			<div className="inner-sidebar-wrapper">
				<div className="sidebar-heading">
					<h4>my {app.name} bag.</h4>
					<span className="close-sidebar" onClick={() => handleClick(cartCount)}>&times;</span>
				</div>
				{/* Related Product Listing */}
				<div className="cart-items">
					<ul className="list-unstyled">
					{relatedProducts.length>0 ?(<h3>Related Products </h3>): ""}
						
						{relatedProducts.length>0 && relatedProducts.map((product, k) => {
							let image = '';
						//console.log('product', product)
							if(product.image){
							image = 'storage/products/' + product.image;
							}
							
							return(
							<li key={k}>
								{image &&
								<div className="cart-image">
									<img src={image}/>
								</div>
								}
								<div className="cart-cntnt">
									<h5 className="cart-heading">{product.title}</h5>
									<p className="product-quantity">{product.description}</p>
									<div className="quantity-flex">
										<div className="quantity-div">
											<div className="number-input md-number-input">
												
												
											</div>
										</div>
										
									</div>
								</div>
								<button className="btn btn-success" onClick={() => addToCart( product.id,product.store_id)}>Add</button>
							</li>
							);
						})}
					</ul>
				</div>

				{/* END RELATED PRODUCT LISTING */}
				{/* CART PRODUCT LIST  */}
				 <div className="cart-items">
					<ul className="list-unstyled">
						{cartData.length>0 && cartData.map((cart, k) => {
							console.log('cart', cart)
							let image = '';
							if(cart.product.image){
							image = 'storage/products/' + cart.product.image;
							}
							let tprice = cart.quantity * cart.product.price;
							totalPrice = totalPrice + tprice;
							return(
							<li key={k}>
								{image &&
								<div className="cart-image">
									<img src={image}/>
								</div>
								}
								<div className="cart-cntnt">
									<h5 className="cart-heading">{cart.product.title}</h5>
									<p className="product-quantity">{cart.product.description}</p>
									{cart.type=='Variable' &&
									<p className="product-quantity">Size: {cart.product.sizes}</p>
									
									}
									<div className="quantity-flex">
										<div className="quantity-div">
											<div className="number-input md-number-input">
												{cart.quantity>1 && 
												<button className="minus" onClick={() => handleAction('minus', cart.id, cart.carts_id)}>-</button>
												}
												<TextInput
													className="quantity"
													name="quantity"
													value={cart.quantity}
													disabled
													type="text"
													error={false}
													onChange={handleChange}
													/>
												{(cart.quantity<cart.product.qty) &&
												<button className="plus" onClick={() => handleAction('plus', cart.id, cart.carts_id)}>+</button>
												}
											</div>
										</div>
										<div className="price-box">
											<p className="price">x ${cart.product.price}</p>
											{tprice>0 && <p className="price">${tprice}</p>}
										</div>
										

									</div>
									{/* <div className="price-box">
											<p className="price">Size: 
											{ cart.attributes.length>0 && cart.attributes.map((cartattr, k) => {
						                 	
											 console.log('uyuyuyuyuy', cartattr);
											 return <button className="btn btn-success" onClick={() => cartAttr(product.id,product.store_id)}>{cartattr.value}</button>

											})
											
											}</p>
											
										</div> */}
								</div>
								<span className="cart-close" onClick={() => handleAction('delete', cart.id, cart.carts_id)}>&times;</span>
							</li>
							);
						})}
					</ul>
				</div> 
				
			
			
			
				{/* CART PRODUCTS LISTING END */}
				<div className="sideBar-form">
					<form onSubmit={handleSubmit}>
						
						{!auth.user &&
						<p>First time? 
						<a href="#" onClick={() => showModal('register')}> Sign Up </a>
						to checkout, if not just 
						<a href="#" onClick={() => showModal('login')}> Login </a>
						</p>
						}
						
						
						{!paymentPage &&
						<>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Full Name"
								name="name"
								type="text"
								value={values.name}
								errors={errors.name}
								onChange={handleChange}
								onClick={() => checkAuth()}
								/>
						</div>
						
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Phone Number"
								name="phone_number"
								type="number"
								disabled={auth.user && "disabled"}
								value={values.phone_number}
								errors={errors.phone_number}
								onChange={handleChange}
								onClick={() => checkAuth()}
								/>
						</div>
						
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Email"
								name="address"
								type="text"
								value={values.email}
								errors={errors.email}
								onChange={handleChange}
								onClick={() => checkAuth()}
								/>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="(Optional) Size/Directions"
								name="notes"
								type="text"
								value={values.notes}
								errors={errors.notes}
								onChange={handleChange}
								onClick={() => checkAuth()}
								/>
						</div>
						
						<div className="row">
							<div className={`form-grouph input-design ${values.promo_code ? 'col-md-8' : 'col-md-12'}`}>
								<TextInput
									placeholder="Promo Code"
									name="promo_code"
									type="text"
									disabled={discount.discount && "disabled"}
									value={values.promo_code}
									errors={errors.promo_code}
									onChange={handleChange}
									onClick={() => checkAuth()}
									/>
							</div>
							{values.promo_code &&
							<div className="form-grouph input-design col-md-4">
								{!discount.discount &&
								<LoadingButton
									type="button"
									className="pink-btn-design"
									onClick={() => checkPromoCode()}
									>
									Apply
								</LoadingButton>
								}
								{discount.discount &&
								<LoadingButton
									type="button"
									className="pink-btn-design"
									onClick={() => removePromoCode()}
									>
									Remove
								</LoadingButton>
								}
							</div>
							}
						</div>
				
						
						</>
						}
						
						{paymentPage &&
						<div className="row">
						
						<p>
						<a href="#" onClick={() => setPaymentPage(false)}> Edit Personal Information </a>
						</p>

						<div className="payment-type">
							<div className="pay-option">
							<label> Pickup Time</label>
								<input type="time" name="pickup_time" class="form-control" 	onChange={handleChange} required/>
								
							</div>
							
							<div className="pay-option">
							<label> Pickup Date</label> 
								<input type="text" name="pickup_date" class="form-control" defaultValue={currentDate} required readOnly/>
							</div>		
						</div>	
						
						<div className="payment-type">
							<div className="pay-option">
							<input type="radio" name="paymentType" onClick={()=>setPaymentType('creditcard')} checked={paymentType=='creditcard' ? 'checked' : ''}/>
								<label> Pay with Credit Card</label>
							</div>
							
							<div className="pay-option">
								<input type="radio" name="paymentType" onClick={()=>setPaymentType('venmo')} checked={paymentType=='venmo' ? 'checked' : ''}/>
								<label> Pay with Venmo or Cash App</label>
							</div>		
						</div>	
						
						{paymentType=='creditcard' &&
						<>
						
						{(savedCard && savedCard.card_number) &&
						<div className="card">
							<b className="cardTitle">Saved Card</b>
							<p className="cardNum">{savedCard.card_number}</p>
							<button type="button" className="btn btn-primary" onClick={()=>useCard(savedCard)}>USE</button>
						</div>
						}
						
						<div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Name"
									name="card_name"
									type="text"
									value={values.card_name}
									errors={errors.card_name}
									onChange={handleChange}
									/>
							</div>
						</div>
						
						<div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Zip Code"
									name="zip_code"
									type="text"
									value={values.zip_code}
									errors={errors.zip_code}
									onChange={handleChange}
									/>
							</div>
						</div>
						
						<div className="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Credit Card Number"
									name="card_number"
									type="number"
									value={values.card_number}
									errors={errors.card_number}
									onChange={handleChange}
									/>
							</div>
						</div>
						
						<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
							<div className="form-grouph input-design">
								<SelectInput
									placeholder="Month"
									name="expire_month"
									errors={errors.expire_month}
									value={values.expire_month}
									onChange={handleChange}
									>
									<option value="">Month</option>
									{months.length>0 && months.map((month, key) => {
									return(
										<option key={key} value={month[1]}>
											{month[0]}
										</option>
									);
									})}
								</SelectInput>
							</div>
						</div>
						<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
							<div className="form-grouph input-design">
								<SelectInput
									placeholder="Year"
									name="expire_year"
									errors={errors.expire_year}
									value={values.expire_year}
									onChange={handleChange}
									>
									<option value="">Year</option>
									{years.length>0 && years.map((year, key) => {
									return(
										<option key={key} value={year}>
											{year}
										</option>
									);
									})}
								</SelectInput>
							</div>
						</div>
						<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
							<div className="form-grouph input-design">
								<TextInput
									placeholder="CVV"
									name="cvv"
									type="password"
									value={values.cvv}
									errors={errors.cvv}
									onChange={handleChange}
									/>
							</div>
						</div>
						</>
						}
						<div className="form-button-flex">
							<button type="button" className={`btn rectangular-btn ${tip==0 ? 'active' : ''}`} onClick={()=>addTip(0)}>No Tip</button>
							<button type="button" className={`btn rectangular-btn ${tip==1 ? 'active' : ''}`} onClick={()=>addTip(1)}>$1</button>
							<button type="button" className={`btn rectangular-btn ${tip==3 ? 'active' : ''}`} onClick={()=>addTip(3)}>$3</button>
							<button type="button" className={`btn rectangular-btn ${customTip ? 'active' : ''}`} onClick={()=>{addTip(0);setCustomTip(true);}}>Custom</button>
						</div>
						
						{customTip &&
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Custom Tip"
								name="tip"
								type="number"
								min={0}
								value={values.tip}
								errors={errors.tip}
								onChange={handleChange}
								/>
						</div>
						}
						</div>
						}
						

						
						<div className="price-checkout">
							<div>
								<p>Subtotal</p>
								<p className="price">${ (parseFloat(totalPrice) + parseFloat(tip)).toFixed(2) }</p>
							</div>							
							
							<div>
								<p>Tax</p>
								<p className="price">${ tax }</p>
							</div>
							
							<div>
								<p>Delivery Charges</p>
								<p className="price">${ deliveryCharges }</p>
							</div>
							
							
							{discount.discount &&
							<div>
								<p>Discount</p>
								<p className="price">{discount.coupon_type=='fixed'?'$':''}{ discount.discount }{discount.coupon_type=='percentage'?'%':''}</p>
							</div>
							}
							
							<div>
								<p><strong>Total</strong></p>
								<p className="price">${ parseFloat(payAmount).toFixed(2) }</p>
							</div>
							
							
						</div>
						<div className="checkout-btn-box">
							<LoadingButton
								type="submit"
								loading={sending}
								className="checkoutBtn"
								>
								{paymentPage?'Place an Order':'Next'}
							</LoadingButton>
						</div>
					</form>
				</div>
			</div>
			
			
		</div>
	);
};
