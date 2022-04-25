import React, { useState, useEffect, useRef } from 'react';
import Helmet from 'react-helmet';
import axios from 'axios';
import { scroller } from 'react-scroll';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import { ToastContainer, toast } from 'react-toastify';
// import 'react-toastify/dist/ReactToastify.css';
import Moment from 'moment';
import MomentTz from 'moment-timezone';

import Layout from '@/Shared/Layout';

const Favourite = () => {
	const { props } = usePage();
	const { app } = props;
	const [products, setProducts] = useState([]);	
	const [productPopup, setProductPopup] = useState({});
	const [cartCount, setCartCount] = useState(0);
	const [cartPrice, setCartPrice] = useState(0);
	const [storeHours, setStoreHours] = useState(true);
	const [isFav, setIsFav] = useState(false);
	
	
	let uuid = localStorage.getItem("uuid");
	
	let current_hour = MomentTz().tz('America/Chicago').format("HHmm");
	
	//...
	let start_time = app.settings.start_time;
	let close_time = app.settings.close_time;
	
	let currentDay = MomentTz().tz('America/Chicago').format("dddd");
	if(currentDay=='Thursday' || currentDay=='Friday' || currentDay=='Saturday'){
		start_time = app.settings.start_time_second;
		close_time = app.settings.close_time_second;
	}

	let start_time_show = Moment(start_time, 'HH:mm').format("hh:mm A");
	let close_time_show = Moment(close_time, 'HH:mm').format("hh:mm A");
	
	start_time = Moment(start_time, 'HH:mm').format("HHmm");
	close_time = Moment(close_time, 'HH:mm').format("HHmm");
	
	//...
	const setCartPopup = (count, price) => {
		setCartCount(count);
		setCartPrice(price.toFixed(2));
	};
	
	//...
	useEffect(() => {
		if(app.settings.store_online=='1' && (current_hour >= start_time || current_hour < close_time)){
			setStoreHours(true);
		}
		else {
			setStoreHours(false);
		}
		
		//...
		async function fetchData() {
			try {
				let uuid = localStorage.getItem("uuid");
				let page = 'fav';
				let data = { uuid, page };
				await axios.get(route('favourite.data', data)).then(res => {
					setProducts(res.data.products);
				});
			} catch (error) {
				setProducts([]);
			}
		}
		fetchData();
	}, []);
	
	//favourite
	function favourite(product) {
		let uuid = localStorage.getItem("uuid");
		let page = 'fav';
		let data = { uuid, product, page };
		axios.post(route('favourite.action'), data).then(res => {
			setProducts(res.data.products);
			toast(res.data.message);
			setProductPopup({});
		});
	}
	
	//...addToCart
	function addToCart(product) {
		setProductPopup({});
		let data = { uuid, product };
		axios.post(route('cart.store'), data).then(res => {
			setCartCount(res.data.count);
			setCartPrice(res.data.price.toFixed(2));
		});
	}
	
    return (
		<Layout setCartPopup={setCartPopup} cartCount={cartCount} cartPrice={cartPrice}>
		<div>
			<Helmet title="Favorite" />
			
			<main className="main-content">
				<div className="shop-page-wrapper favourite">
					<div className="container">
						
						{!storeHours &&
							<div className="alert alert-danger">
								<strong>Store Hours {start_time_show} - {close_time_show}</strong>
							</div>
						}
						
						<div className="shopping-inner-container">
							<div className="products-sec">								
								
								{products.length>0 && products.map((fav, k) => {
								let product = fav.product;
								let image = 'storage/products/' + product.image;
								return(
									<div className="col-xl-3 col-lg-3 col-md-6 col-sm-12" key={k}>
										<div className="products">
											<div className="product-img" onClick={() => setProductPopup(product)}>
												<img src={image}/>
											</div>
											<div className="product-cntnt">
												<p className="product-name">{product.title}</p>
												<p className="product-price">${product.price}</p>
												{product.qty==0 &&
													<span className="out-stock">Out of Stock</span>
												}
											</div>
											<div className="add-to-cart">
												{isFav &&
													<span onClick={() => favourite(product.id)}>
													<i className="fas fa-heart"></i>
													</span>
												}
												
												{(storeHours && product.qty>0) &&
												<span onClick={() => addToCart(product.id)}>
													<i className="fas fa-plus-circle"></i>
												</span>
												}
											</div>
										</div>
									</div>
									);
								})}
								
								
							</div>
						</div>
					</div>
				</div>
			</main>			
			
			
			{productPopup.title &&
			<div id="product-popup" className="active">
				<div className="product-popup-inner-wrapper">
					<div className="product-large-img text-center">
						<img src={`storage/products/${productPopup.image}`}/>
					</div>
					<div className="product-popup-cntnt">
						<p className="product-name">{productPopup.title}</p>
						<p className="product-price">${productPopup.price}</p>
						
						<button className="cart-btn pink-btn-design" onClick={() => favourite(productPopup.id)}>Remove Favorite</button>
						
						{(storeHours && productPopup.qty>0) &&
						<button className="cart-btn pink-btn-design" onClick={() => addToCart(productPopup.id)}>Add To Cart</button>
						}
						{productPopup.qty==0 &&
							<span className="out-stock">Out of Stock</span>
						}
						
						<span className="close-popup" onClick={() => setProductPopup({})}>×</span>
					</div>
				</div>
			</div>
			}
			
		</div>
		</Layout>
    );
};

export default Favourite;