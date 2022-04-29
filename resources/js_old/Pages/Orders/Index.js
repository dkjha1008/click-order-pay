import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';
import Moment from 'moment';
import MomentTz from 'moment-timezone';
import { ToastContainer, toast } from 'react-toastify';
// import 'react-toastify/dist/ReactToastify.css';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';

const Index = () => {
	const { props } = usePage();
	const { auth, errors, orders, app } = props;
	const [storeHours, setStoreHours] = useState(false);
	
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
	useEffect(() => {
		if(app.settings.store_online=='1' && (current_hour >= start_time || current_hour < close_time)){
			setStoreHours(true);
		}
		else {
			setStoreHours(false);
		}
	}, [storeHours]);
	
	function addToCart(cart,store_id) {
		debugger;
		console.log(store_id,cart)
		let uuid = localStorage.getItem("uuid");
		let data = { uuid, cart,store_id };
		if(storeHours){
			localStorage.setItem('sidebar', 'opned');
			Inertia.post(route('cart.reorder'), data).then(res => {
				
			});
		}
		else {
			let time = 'Store Hours ' + start_time_show + ' - ' + close_time_show;
			toast(time);
		}
	}
	
    return (
		<Layout>
		<div>
			<Helmet title="My Orders" />
			
			<main className="main-content">
				<div className="container">
					<div className="order-hitory max-1140">
						<div className="order-histor-heading">
							<h2>order history</h2>
						</div>
						<div className="order-history-wrapper">
							
							{orders.length>0 && orders.map((order, key) => {
							return(
							<div className="row align-items-center" key={key}>  
								<div className="col-xl-2 col-lg-2 col-md-2 col-sm-12">
									<div className="date-wrap">
										<p className="date">{Moment(order.created_at).format('DD-MM-YYYY')}</p>
									</div>
								</div>
								<div className="col-xl-3 col-lg-3 col-md-3 col-sm-12">
									<div className="order-details">
										<p className="order">
										{order.product.length>0 && order.product.map((product, key) => {
											return(
											<span key={key}>
											{key>0 && ', '}{product.title}
											</span>
											);
										})}
										</p>
									</div>
								</div>
								<div className="col-xl-2 col-lg-2 col-md-2 col-sm-12">
									<div className="status-box">
										<p className="status">{order.order_status.name}</p>
									</div>
								</div>
								<div className="col-xl-2 col-lg-2 col-md-2 col-sm-12">
									<div className="price-box">
										<p className="price">${order.amount}</p>
									</div>
								</div>
								<div className="col-xl-3 col-lg-3 col-md-3 col-sm-12">
									<div className="order-details-btns">
									<InertiaLink href={route('orders.show', order.id)} className="view-order pink-radius-btn">VIEW ORDER</InertiaLink>
									
									<a href="#" onClick={() => addToCart(order.carts.id,order.product[0].store_id)} className="re-order pink-radius-btn">REORDER</a>
									
									</div>
								</div>
							</div>
							);
							})}
							
						</div>
					</div>
				</div>
			</main>
			
		</div>
		</Layout>
    );
};

export default Index;