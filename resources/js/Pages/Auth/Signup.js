import React, { useState } from 'react';
import Helmet from 'react-helmet';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import { ToastContainer, toast } from 'react-toastify';
// import 'react-toastify/dist/ReactToastify.css';
import Auth from '@/Shared/Auth';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

export default () => {
	const { props } = usePage();
	const { errors, app } = props;
	const [sending, setSending] = useState(false);
	const [modalOtp, setModalOtp] = useState(false);
	
	const [values, setValues] = useState({
		type: 'user',
		name: '',
		phone_number: '',
		email:'',
		password: '',
		password_confirmation: '',
		otp: '',
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
		axios.post(route('signup.attempt'), values).then((res) => {
			toast(res.data.message);
			setSending(false);
			if(res.data.type=='success'){
				setModalOtp(true);
			}
		});
	}
	
	function handleSubmitOtp(e) {
		e.preventDefault();
		setSending(true);
		Inertia.post(route('signup.otp'), values).then(() => {
			setSending(false);
		});
	}
	
	//...
	function resendOtp() {
		axios.post(route('resend.otp'), values).then((res) => {
			toast(res.data.message);
		});
	}
  
    return (
		<Auth>
		<div>
			<Helmet title="Register New Account" />
	
			<main className="main-content">
				<div className="authentication-page-wrapper max-562">
					<div className="container">
						
						{modalOtp==false &&
						<form onSubmit={handleSubmit} id="login-form">
							<div className="form-grouph form-heading text-center">
							<h2>Sign Up</h2>
							</div>
							
							<div className="row mb-4">
								<div className="col-md-6">
									<button type="button"
										name="type"
										value="user"
										onClick={handleChange}
										className={`btn btn-lg btn-block btn-${values.type=='user' ? 'dark' : 'light' }`}
										>
										Customer
									</button>
								</div>

								<div className="col-md-6">
									<button type="button"
										name="type"
										value="store"
										onClick={handleChange}
										className={`btn btn-lg btn-block btn-${values.type=='store' ? 'dark' : 'light' }`}
										>
										Store
									</button>
								</div>
							</div>

							<div className="form-grouph input-design">
								<TextInput
									placeholder={values.type=='store' ? 'Company Name' : 'Name' }
									name="name"
									type="text"
									value={values.name}
									errors={errors.name}
									onChange={handleChange}
									required={true}
									/>
							</div>

							{values.type=='user' &&
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Phone Number"
									name="phone_number"
									type="number"
									value={values.phone_number}
									errors={errors.phone_number}
									onChange={handleChange}
									required={true}
									/>
							</div>
							}

							<div className="form-grouph input-design">
								<TextInput
									placeholder="Email"
									name="email"
									type="email"
									value={values.email}
									errors={errors.email}
									onChange={handleChange}
									required={true}
									/>
							</div>
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Password"
									name="password"
									type="password"
									value={values.password}
									errors={errors.password}
									onChange={handleChange}
									required={true}
									/>
							</div>
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Confirm Password"
									name="password_confirmation"
									type="password"
									value={values.password_confirmation}
									errors={errors.password_confirmation}
									onChange={handleChange}
									required={true}
									/>
							</div>
							<div className="form-grouph submit-design text-center margin-auto">
								<LoadingButton
									type="submit"
									loading={sending}
									className="pink-btn-design"
									>
									SIGN UP
								</LoadingButton>
							</div>
							
							<div className="form-grouph signup-text text-center">
								<p>By clicking signup, I have confirmed to provide acceptance to <a target="_blank" href={`${app.url}SHMACKED-TERMS.pdf`}>Terms</a> and <a target="_blank" href={`${app.url}SHMACKED-PRIVACY-POLICY.pdf`}>Privacy Policy</a> of {app.name}</p>								
							</div>								
							<div className="form-grouph signup-text text-center">
								<p>Already signed up with {app.name}? 
									<InertiaLink href={route('signin')}> Login</InertiaLink>
								</p>
							</div>
			   
						</form>
						}
						
						{modalOtp &&
						<form onSubmit={handleSubmitOtp} id="login-form">
							<div className="form-grouph form-heading text-center">
								<h2>Verification Code</h2>
							</div>
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Code"
									name="otp"
									type="number"
									value={values.otp}
									errors={errors.otp}
									onChange={handleChange}
									/>
							</div>
							<a href="javascript:void(0)" className="resendOtp" onClick={() => resendOtp()}>Resend Code</a>
							<div className="form-grouph submit-design text-center margin-auto">
								<LoadingButton
									type="submit"
									loading={sending}
									className="pink-btn-design"
									>
									Sign Up
								</LoadingButton>
							</div>
						</form>
						}
						
					</div>
				</div>
			</main>
			</div>
	</Auth>
    );
};