import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';

import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

const Checkout = () => {
	const { props } = usePage();
	const { auth, errors, user } = props;
	
	const [sending, setSending] = useState(false);
	const [values, setValues] = useState({
		name: user.name,
		phone_number: user.phone_number,
		address: user.address,
		notes: user.notes,
		city: user.city,
		state: user.state,
		zip_code: user.zip_code,
		card_number: '',
		cvv: '',
		expire_month: '',
		expire_year: '',
	});
	
	function handleChange(e) {
		const key = e.target.name;
		const value =
		e.target.type === 'checkbox' ? e.target.checked : e.target.value;

		setValues(values => ({
			...values,
			[key]: value
		}));
	}
	
	function handleSubmit(e) {
		e.preventDefault();
		setSending(true);
		Inertia.post(route('checkout.store'), values).then(() => {
			setSending(false);
		});
	}
	
	
	
    return (
		<Layout>
		<div>
			<Helmet title="Checkout" />
			<main className="main-content">
				<div className="account-page-wrapper authentication-page-wrapper max-1140">
					<div className="container">
						<form onSubmit={handleSubmit}>
							<div className="row">
								<div className="col-sm-12">
									<div className="form-grouph form-heading">
										<h2>account details</h2>
									</div>
								</div>
								<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Full Name"
											name="name"
											type="text"
											value={values.name}
											errors={errors.name}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Phone Number"
											name="phone_number"
											type="text"
											disabled
											value={values.phone_number}
											errors={errors.phone_number}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Address"
											name="address"
											type="text"
											value={values.address}
											errors={errors.address}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Directions (optional)"
											name="notes"
											type="text"
											value={values.notes}
											errors={errors.notes}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="City"
											name="city"
											type="text"
											value={values.city}
											errors={errors.city}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="State"
											name="state"
											type="text"
											value={values.state}
											errors={errors.state}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
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
							</div>
							<div className="row">
								<div className="col-sm-12">
									<div className="form-grouph form-heading">
										<h2>payment information</h2>
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
										<TextInput
											placeholder="CCV"
											name="cvv"
											type="number"
											value={values.cvv}
											errors={errors.cvv}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Expire Month"
											name="expire_month"
											type="number"
											value={values.expire_month}
											errors={errors.expire_month}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-xl-4 col-lg-4 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Expire Year"
											name="expire_year"
											type="number"
											value={values.expire_year}
											errors={errors.expire_year}
											onChange={handleChange}
											/>
									</div>
								</div>
								
								
								
								
								
								
								<div className="col-sm-12">
									<div className="form-grouph submit-design">
										
										<LoadingButton
											type="submit"
											loading={sending}
											className="pink-btn-design"
											>
											Make Payment
										</LoadingButton>
								
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</main>
			
		</div>
		</Layout>
    );
};

export default Checkout;