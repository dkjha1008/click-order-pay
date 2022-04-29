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
	const { errors } = props;
	const [sending, setSending] = useState(false);
	const [otpField, setOtpField] = useState('forgot');
	
	const [values, setValues] = useState({
		phone_number: '',
		otp: '',
		password: '',
		password_confirmation: '',
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
		values['type'] = otpField;
		
		if(otpField=='password'){
			values['page'] = 'login';
			Inertia.post(route('password.inertia'), values).then((res) => {
				//...
				setSending(false);
			});
		}
		else {		
			axios.post(route('password'), values).then((res) => {
				toast(res.data.message);
				setSending(false);
				if(res.data.type=='success'){
					if(otpField=='forgot'){
						setOtpField('otp');
					}
					if(otpField=='otp'){
						setOtpField('password');
					}
				}
			});
		}		
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
			<Helmet title="Forgot Password" />
	
			<main className="main-content">
				<div className="authentication-page-wrapper max-562">
					<div className="container">
						<form onSubmit={handleSubmit} id="login-form">
							
							
							{otpField=='forgot' &&
							<>
							<div className="form-grouph form-heading text-center">
								<h2>Forgot Password</h2>
							</div>
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Phone Number"
									name="phone_number"
									type="number"
									value={values.phone_number}
									errors={errors.phone_number}
									onChange={handleChange}
									/>
							</div>
							</>
							}
							
							{otpField=='otp' &&
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
							
							{otpField=='password' &&
							<>
							<div className="form-grouph form-heading text-center">
								<h2>Enter New Password</h2>
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
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Confirm Password"
									name="password_confirmation"
									type="password"
									value={values.password_confirmation}
									errors={errors.password_confirmation}
									onChange={handleChange}
									/>
							</div>
							</>
							}
							
							<div className="form-grouph submit-design text-center margin-auto">
								<LoadingButton
									type="submit"
									loading={sending}
									className="pink-btn-design"
									>
									{otpField=='forgot' && 'Forgot Password'}
									{otpField=='otp' && 'Confirm Otp'}
									{otpField=='password' && 'Change Password'}
								</LoadingButton>
							</div>
							<div className="form-grouph signup-text text-center">
								<p>If Remember? 
									<InertiaLink href={route('signin')}> Login</InertiaLink>
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