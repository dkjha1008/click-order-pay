import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';

import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';
import SelectInput from '@/Shared/SelectInput';

const Profile = () => {
	const { props } = usePage();
	const { auth, errors, user, months, years, address } = props;

	const [sending, setSending] = useState(false);
	const [sendingPay, setSendingPay] = useState(false);
	
	const [values, setValues] = useState({
		name: user.name ?? '',
		phone_number: user.phone_number ?? '',
		address: user.address ?? '',
		notes: user.notes ?? '',
		zip_code: user.zip_code ?? '',
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
		Inertia.post(route('profile.update'), values).then(() => {
			setSending(false);
		});
	}
	
	
	//---card
	const [cardValues, setCardValues] = useState({
		card_name: address && address.card_name ? address.card_name : '',
		card_number: address && address.card_number ? address.card_number : '',
		expire_month: address && address.expire_month ? address.expire_month : '',
		expire_year: address && address.expire_year ? address.expire_year : '',
	});
	
	function handleChangeCard(e) {
		const key = e.target.name;
		const value =
		e.target.type === 'checkbox' ? e.target.checked : e.target.value;

		setCardValues(cardValues => ({
			...cardValues,
			[key]: value
		}));
	}
	
	function handleSubmitCard(e) {
		e.preventDefault();
		setSendingPay(true);
		Inertia.post(route('profile.address'), cardValues).then(() => {
			setSendingPay(false);
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
										<h2>Account Details</h2>
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
								<div className="col-xl-9 col-lg-6 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="(Optional) Special Instructions/Directions"
											name="notes"
											type="text"
											value={values.notes}
											errors={errors.notes}
											onChange={handleChange}
											/>
									</div>
								</div>
								<div className="col-xl-3 col-lg-6 col-md-6 col-sm-12">
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
									<div className="form-grouph submit-design">
										
										<LoadingButton
											type="submit"
											loading={sending}
											className="pink-btn-design"
											>
											Update
										</LoadingButton>
										
									</div>
								</div>
							</div>
						</form>
							
						<form onSubmit={handleSubmitCard}>	
							<div className="row">
								<div className="col-sm-12">
									<div className="form-grouph form-heading">
										<h2>Payment information <span className="small-text">(Optional because we also accept Venmo)</span></h2>
									</div>
								</div>
								
								
								<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Card Name"
											name="card_name"
											type="text"
											value={cardValues.card_name}
											errors={errors.card_name}
											onChange={handleChangeCard}
											/>
									</div>
								</div>
								<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<TextInput
											placeholder="Credit Card"
											name="card_number"
											type="number"
											value={cardValues.card_number}
											errors={errors.card_number}
											onChange={handleChangeCard}
											/>
									</div>
								</div>
								<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<SelectInput
											placeholder="Month"
											name="expire_month"
											errors={errors.expire_month}
											value={cardValues.expire_month}
											onChange={handleChangeCard}
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
								<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div className="form-grouph input-design">
										<SelectInput
											placeholder="Year"
											name="expire_year"
											errors={errors.expire_year}
											value={cardValues.expire_year}
											onChange={handleChangeCard}
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
							</div>
				  
				  
							<div className="row">
								<div className="col-sm-12">
									<div className="form-grouph submit-design">
										
										<LoadingButton
											type="submit"
											loading={sendingPay}
											className="pink-btn-design"
											>
											Update
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

export default Profile;