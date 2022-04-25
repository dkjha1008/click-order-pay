import React, { useState, useEffect, useRef } from 'react';
import Helmet from 'react-helmet';
import axios from 'axios';
import { scroller } from 'react-scroll';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import pickBy from 'lodash/pickBy';
import Moment from 'moment';
import MomentTz from 'moment-timezone';
import { ToastContainer, toast } from 'react-toastify';
// import 'react-toastify/dist/ReactToastify.css';

import Layout from '@/Shared/Layout';

const Ucla = () => {
	const { props } = usePage();
	const { category, products, allcat, app, auth } = props;
	
	const [productPopup, setProductPopup] = useState({});
	const [userFavourite, setUserFavourite] = useState([]);
	const [cartCount, setCartCount] = useState(0);
	const [cartPrice, setCartPrice] = useState(0);
	const [storeHours, setStoreHours] = useState(true);
	const [isFav, setIsFav] = useState(false);
	
	let uuid = localStorage.getItem("uuid");
	
	const [values, setValues] = useState({
		type: '',
		search: '',
	});
	
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
	
	const setCartPopup = (count, price) => {
		setCartCount(count);
		setCartPrice(price.toFixed(2));
	};
	
	useEffect(() => {
		if(app.settings.store_online=='1' && (current_hour >= start_time || current_hour < close_time)){
			setStoreHours(true);
		}
		else {
			setStoreHours(false);
		}
		
		//---
		if(route().params.category){
			scrollerRef(route().params.category);
		}
		
		if(route().params.search){
			setValues(values => ({
				...values,
				search: route().params.search
			}));
		}
		
		if(route().params.type){
			setValues(values => ({
				...values,
				type: route().params.type
			}));
		}
		
		async function fetchCartCount() {
			try {
				let data = { uuid };
				await axios.get(route('cart.index', data)).then(res => {
					setCartCount(res.data.count);
					setCartPrice(res.data.price.toFixed(2));
				});
				await axios.get(route('favourite.data', data)).then(res => {
					setUserFavourite(res.data.products);
				});
			} catch (error) {
				setCartCount(0);
				setCartPrice(0);
			}
		}
		fetchCartCount();
		
	}, []);
	
	
	function search(e) {
		e.preventDefault();
		const query = Object.keys(pickBy(values)).length
			? pickBy(values)
			: {};
		Inertia.replace(route(route().current(), query));
	}
	
	
	function scrollerRef(ref) {
		setValues(values => ({
			...values,
			type: ref
			}));
		scroller.scrollTo(ref, {
			duration: 1000,
			delay: 2,
			smooth: "easeInOutQuart",
		});
	}
	
	function addToCart(product) {
		setProductPopup({});
		let data = { uuid, product };
		axios.post(route('cart.store'), data).then(res => {
			setCartCount(res.data.count);
			setCartPrice(res.data.price.toFixed(2));
		});
	}
	
	function handleChange(e) {
		const key = e.target.name;
		const value = e.target.value;

		setValues(values => ({
			...values,
			[key]: value
		}));
	}
	
	//favourite
	function favourite(product) {
		let data = { uuid, product };
		axios.post(route('favourite.action'), data).then(res => {
			setUserFavourite(res.data.products);
			toast(res.data.message);
		});
	}
	
    return (
		<Layout setCartPopup={setCartPopup} cartCount={cartCount} cartPrice={cartPrice}>
		<div>
			<Helmet title="Shmacked - UT Austin's Fastest Delivery Service" />
			
			<main className="main-content">
				<div className="shop-page-wrapper">
					<div className="container">
						{!storeHours &&
							<div className="alert alert-danger">
								<strong>Store Hours {start_time_show} - {close_time_show}</strong>
							</div>
						}

						<div className="shopping-inner-container">
							<form onSubmit={search} className="shop-filter-sec">
								<div className="left-category-wrap">
									<select onChange={(event) => {scrollerRef(event.target.value)}}>
										<option value="">Select a Category</option>
										{allcat.length>0 && allcat.map((cat, key) => {
											return(
											<option value={cat.slug} key={key}>{cat.name}</option>
											);
										})}
									</select>
								</div>
								<div className="serach-box">
									<input
										autoComplete="off"
										type="text"
										name="search"
										value={values.search}
										onChange={handleChange}
										placeholder="Search…"
										/>
									<button type="submit" className="search-icn"><i className="fas fa-search"></i></button>
								</div>
							</form>
							<div className="products-sec">
								
								{(!route().params.search && category.length>0) && category.map((cat, key) => {
								return(
									<div className={`recommend-product product-list ${cat.slug}`} key={key}>
										<h2 className="product-heading">{cat.name}</h2>
										<div className="row">
											{cat.products.length>0 && cat.products.map((product, k) => {
											let image = 'storage/products/' + product.image;
											let fav = userFavourite.includes(product.id);
											return(
												<div className="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-6" key={k}>
													<div className="products">
														<div className="product-img" onClick={() => setProductPopup(product)}>
															<img src={image}/>
														</div>
														<div className="product-cntnt">
														<div className="product-name" onClick={() => setProductPopup(product)}>
															<p className="product-name">{product.title}</p>
															</div>
															<p className="product-price">${product.price}</p>			
															{product.qty==0 &&
																<span className="out-stock">Out of Stock</span>
															}				
														</div>
														<div className="add-to-cart">
															
															{isFav &&
															<>
																{fav &&
																<span onClick={() => favourite(product.id)}>
																	<i className="fas fa-heart"></i>
																</span>
																}
																{!fav &&
																<span onClick={() => favourite(product.id)}>
																	<i className="far fa-heart"></i>
																</span>
																}
															</>
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
									);
								})}
								
								
								
								
								{(route().params.search && products.length>0) && products.map((product, k) => {
								let image = 'storage/products/' + product.image;
								let fav = userFavourite.includes(product.id);
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
												<>
													{fav &&
													<span onClick={() => favourite(product.id)}>
														<i className="fas fa-heart"></i>
													</span>
													}
													{!fav &&
													<span onClick={() => favourite(product.id)}>
														<i className="far fa-heart"></i>
													</span>
													}
												</>
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
						<div className="recommend-form">
							<form>
								<div className="form-flex">
									<div className="form-grouph submit-design">
										<a className="black-btn-design" target="_blank" href="https://2qvefy36o93.typeform.com/to/bvGj9Jlb">Didn't find what you wanted? Recommend It</a>
									</div>
								</div>
							</form>
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
						<p className="product-description">${productPopup.description}</p>
						<p className="product-nutrition_info">{productPopup.nutrition_info}</p>
						<button className="cart-btn pink-btn-design" onClick={() => favourite(productPopup.id)}>{userFavourite.includes(productPopup.id) ? 'Remove Favorite' : 'Add To Favorite' }</button>
						
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

export default Ucla;