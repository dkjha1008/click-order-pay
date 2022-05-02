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
	const [otpForm, setOtpForm] = useState(false);
	const [values, setValues] = useState({
		type: 'user',
		phone_number: '',
		password: '',
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
		
		values['email'] = values.phone_number;
		axios.post(route('signin.verify'), values).then((res) => {
			if(res.data.type=='success'){
				if(res.data.otp){
					setOtpForm(true);
					setSending(false);
				}
				else {
					Inertia.post(route('signin.attempt'), values).then(() => {
						setSending(false);
					});
				}
			}
			else {
				setSending(false);
				toast(res.data.message);
			}
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
			<Helmet title="Login" />
	
			<main className="main-content">
				<div className="authentication-page-wrapper max-562">
					<div className="container">
						<form onSubmit={handleSubmit} id="login-form">				
							
							{!otpForm &&
							<>
							<div className="form-grouph form-heading text-center">
								<h2>login</h2>
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
									placeholder={values.type=='store' ? 'Email' : 'Email/ Phone Number' }
									name="phone_number"
									type="text"
									value={values.phone_number}
									errors={errors.phone_number}
									onChange={handleChange}
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
									/>
							</div>
							<div className="form-grouph forget-password text-right">
								<InertiaLink href={route('forgot')}>Forgot Password?</InertiaLink>
							</div>
							</>
							}
							
							{otpForm &&
							<>
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
							</>
							}
							
							<div className="form-grouph submit-design text-center margin-auto">
								<LoadingButton
									type="submit"
									loading={sending}
									className="pink-btn-design"
									>
									{otpForm ? 'Verify OTP' : 'Login' }
								</LoadingButton>
							</div>
							<div className="form-grouph signup-text text-center">
								<p>New to {app.name}? 
									<InertiaLink href={route('signup')}> Sign Up</InertiaLink>
								</p>
							</div>
						</form>
					</div>
				</div>
			</main>
		</div>

	</Auth>
    );
};