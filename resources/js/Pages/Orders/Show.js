import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import Moment from 'moment-timezone';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';

const Show = () => {
	const { props } = usePage();
	const { auth, errors, order, app } = props;
	const [status, setStatus] = useState(0);
	console.log(order)
	//...
	useEffect(() => {
		if(order.all_status.length>0){
			if(order.all_status.length==2){
			setStatus(50);
			}
			if(order.all_status.length==3){
			setStatus(100);
			}
		}
	}, [status]);
	
	function orderAction(order, action) {
		let data = { order, action };
		Inertia.post(route('orders.action'), data).then(res => {
			
		});
	}
	
	
    return (
		<Layout>
		<div>
		<Helmet title="Order Details" />
			
			<main className="main-content">
				<div className="container">
					<div className="cart-detailed-wrapper max-1140 padd-tb-60">
						<div className="order-histor-heading">
							<h2>Order Details
								<div className="pull-right">
									{order.order_status==1 &&
										<a className="btn btn-danger" href="#" onClick={()=>orderAction(order.id, 'cancle')}>Cancel Order</a>
									}
									<InertiaLink className="btn btn-warning" href={route("orders")}><i className="fa fa-arrow-left"></i> Back</InertiaLink>
								</div>
							</h2>
						</div>
						
						{order.payment_status=='captured' &&
						<>
							{order.is_progress=='0' &&
							<div className="alert alert-info">
								<strong>{order.orderStatus.name}</strong>
							</div>
							}
							
							{order.is_progress=='1' &&
							<div className="alert alert-warning">
								<strong>Payment in progress</strong>
							</div>
							}
							
							{(order.order_status==3 && order.is_admin_cancle=='0') &&
							<div className="alert alert-info">
								<strong>{order.orderStatus.name}</strong>
							</div>
							}
							{(order.order_status==3 && order.is_admin_cancle=='1') &&
							<div className="alert alert-info">
								<strong>Your order has been cancelled</strong>
								<p>We will refund you ${order.amount}</p>
							</div>
							}
						</>
						}
						
						{(order.payment_status=='pending') &&
						<>
							{order.order_status!=3 &&
							<>
								<div className="alert alert-warning">
									<strong>Order Payment Pending</strong>
								</div>
								
								<div className="alert alert-info">
								Please complete your payment on Venmo to @shmackedut so we can deliver your order.
									<a target="_blank" href={`venmo://paycharge?txn=pay&recipients=shmackedut&amount=${order.amount}&note=SHMACKED.COM: 15 minute delivery order #${order.id}`}> Pay with Venmo ${order.amount}</a>
								</div>
							</>
							}
							{(order.order_status==3 && order.is_admin_cancle=='0') &&
							<div className="alert alert-info">
								<strong>{order.orderStatus.name}</strong>
							</div>
							}
							{(order.order_status==3 && order.is_admin_cancle=='1') &&
							<div className="alert alert-info">
								<strong>Your order has been cancelled</strong>
							</div>
							}
						</>
						}
						
						
						<div className="shopping-cart">
							<div className="column-labels">
								<label className="product-image">Image</label>
								<label className="product-details">Product</label>
								<label className="product-price">Price</label>
								<label className="product-qty">Qty</label>
								<label className="product-price">Total Price</label>
							</div>
							
							{order.carts.products.length>0 && order.carts.products.map((product, key) => {
							
							console.log('product---', product)
							return(
							<div className="product" key={key}>
								<div className="product-image">
									<img src={`/storage/products/${product.image}`}/>
								</div>
								<div className="product-details">
									<h5 className="cart-heading">{product.title}</h5>
									<p className="product-description">{product.description}</p>
									
									{product.pivot.type=='Variable' &&
									<p className="product-quantity">Size: {product.pivot.size}</p>
									}
									
								</div>
								<div className="product-price">
									<p className="price">${product.pivot.price}</p>
								</div>
								<div className="product-size">
									<p className="size">{product.pivot.quantity}</p>
								</div>
								
								
								<div className="product-price">
									<p className="price">${product.pivot.price*product.pivot.quantity}</p>
								</div>

								
							</div>
							);
							})}
							
							
							
							<div className="total-flex">							
								<div className="total-lft">
									<div className="shipping-details">
										<p><strong>Shipping Address</strong></p>
										<p><strong>Address:</strong> {order.user.address}</p>
										<p><strong>Special Instructions:</strong> {order.user.notes}</p>
										<p><strong>Pickup Date/Time:</strong> {order.carts.pickup_date}/{order.carts.pickup_time}</p>
									</div>
								</div>
							
								<div className="total-right">
									<div className="totals">
										<div className="totals-item">
											<label>Subtotal</label>
											<div className="totals-value" id="cart-subtotal">${parseFloat(order.carts.price) + parseFloat(order.carts.tip)}</div>
										</div>										
										
										{(order.carts.tax && order.carts.tax>0) &&
										<div className="totals-item">
											<label>Tax</label>
											<div className="totals-value" id="cart-tax">${order.carts.tax}</div>
										</div>
										}
										
										{(order.carts.delivery_charges && order.carts.delivery_charges>0) &&
										<div className="totals-item">
											<label>Delivery Charges</label>
											<div className="totals-value" id="cart-tax">${order.carts.delivery_charges}</div>
										</div>
										}
										
										{order.carts.promocode &&
										<div className="totals-item">
											<label>Discount</label>
											<div className="totals-value" id="cart-shipping">
											{order.carts.promo.coupon_type=='fixed'?'$':''}{ order.carts.promo.discount }{order.carts.promo.coupon_type=='percentage'?'%':''}
											</div>
										</div>
										}
										
										<div className="totals-item totals-item-total">
											<label><strong>Total</strong></label>
											<div className="totals-value" id="cart-total">${order.amount}</div>
										</div>
									</div>
								</div>
							</div>
							
							
							{(order.order_status!=3 && order.is_refund=='0') &&
							<div className="order-tracking-bar">
								<div className="order-histor-heading">
									<h2>Order Tracking</h2>
								</div>
								<div className="order-tracking-time-line">
									<div className="row align-items-end">
										<div className="col-xl-9 col-lg-9 col-md-12 col-sm-12">
											<div className="shipping-timeline-structure">
												<div className="grey-green-bar">
													
													<div className="shipp-cntnt-details flex-ship">
														<span className="shipping-value">Pending</span>
														<span className="shipping-value">Ready For Delivery</span>
														<span className="shipping-value">Completed</span>
													</div>
													<div className="centered-bar">
														<div className="grey-line">
															<span className="circle-indicators">&nbsp;</span>
															<span className="circle-indicators">&nbsp;</span>
															<span className="circle-indicators">&nbsp;</span>
														</div>
														<div className="green-line-box" style={{width: `${status}%`}}>
															<div className="green-line">
																<span className="circle-indicators">&nbsp;</span>
																<span className="circle-indicators">&nbsp;</span>
																<span className="circle-indicators">&nbsp;</span>
															</div>
														</div>
													</div>
													<div className="shipp-cntnt-details flex-ship">
														{order.all_status.length>0 && order.all_status.map((status, key) => {
															return(
															<span key={key} className="shipping-date">{Moment.tz(status.created_at, 'America/Chicago').format('DD-MM-YYYY h:mma')}</span>
															);
														})}
														
														{order.all_status.length==2 &&
														<span className="shipping-date"></span>
														}
														
													</div>
													
													
												</div>
											</div>
										</div>
										
										{order.order_status==2 &&
										<div className="col-xl-3 col-lg-3 col-md-12 col-sm-12">
											<div className="derivery-date">
												<p>Order Delivered On <span className="order-deliver-date">{Moment(order.updated_at).format('Do MMM, YYYY')}</span></p>
											</div>
										</div>
										}
										
									</div>
								</div>
							</div>
							}
							
						
						</div>
					</div>
				</div>
			</main>
			
		</div>
		</Layout>
    );
};

export default Show;