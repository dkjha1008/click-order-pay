import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

const ChangePassword = () => {
	const { props } = usePage();
	const { errors } = props;
	
	const [sending, setSending] = useState(false);
	const [values, setValues] = useState({
		current_password: '',
		new_password: '',
		new_password_confirmed: '',
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
		Inertia.post(route('change.password'), values).then(() => {
			setSending(false);
		});
	}	
	
    return (
		<Layout>
		<div>
			<Helmet title="Change Password" />
			
			<main className="main-content">
				<div className="authentication-page-wrapper max-562">
					<div className="container">
						<form onSubmit={handleSubmit} id="login-form">
							<div className="form-grouph form-heading text-center">
								<h2>change password</h2>
							</div>
							
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Current Password"
									name="current_password"
									type="password"
									errors={errors.current_password}
									onChange={handleChange}
									required={true}
									/>
							</div>
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Confirm New Password"
									name="new_password"
									type="password"
									errors={errors.new_password}
									onChange={handleChange}
									required={true}

									/>
							</div>
							<div className="form-grouph input-design">
								<TextInput
									placeholder="Confirm New Password"
									name="new_password_confirmed"
									type="password"
									errors={errors.new_password_confirmed}
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
									Change Password
								</LoadingButton>
							</div>
						</form>
					</div>
				</div>
			</main>
			
		</div>
		</Layout>
    );
};

export default ChangePassword;