import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';

import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

const Contact = () => {

	const { props } = usePage();
	const { errors, app } = props;
	
	const [sending, setSending] = useState(false);
	const [values, setValues] = useState({
		name: '',
		email: '',
		phone_number: '',
		subject: '',
		message: '',
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
		Inertia.post(route('contact.request'), values).then(() => {
			setSending(false);
			});
	}
	
	
    return (
		<Layout>
		<div>
			<Helmet title="Contact Us" />
			
			<main className="main-content">
				<div className="contact-page-wrapper authentication-page-wrapper padd-tb-60">
					<div className="container">
						<div className="row">
							<div className="col-xl-8 col-lg-8 col-md-8 col-sm-12">
								<div className="contact-page-lft-column">
									<div className="form-heading">
										<h2>Contact Us</h2>
									</div>
									<div className="Form-Wrapper">
										<form onSubmit={handleSubmit}>
											<div className="form-grouph input-design form-field">
												<TextInput
													placeholder="Name"
													name="name"
													type="text"
													errors={errors.name}
													value={values.name}
													onChange={handleChange}
													/>
											</div>
											<div className="form-grouph input-design form-field">
												<TextInput
													placeholder="Email"
													name="email"
													type="email"
													errors={errors.email}
													value={values.email}
													onChange={handleChange}
													/>
											</div>
											
											<div className="form-grouph input-design form-field">
												<TextInput
													placeholder="Phone Number"
													name="phone_number"
													type="number"
													errors={errors.phone_number}
													value={values.phone_number}
													onChange={handleChange}
													/>
											</div>
											
											<div className="form-grouph input-design form-field">
												<TextInput
													placeholder="Subject"
													name="subject"
													type="text"
													errors={errors.subject}
													value={values.subject}
													onChange={handleChange}
													/>
											</div>
											<div className="form-grouph input-design form-field">
												<TextInput
													placeholder="Your Message"
													name="message"
													type="text"
													errors={errors.message}
													value={values.message}
													onChange={handleChange}
													/>
											</div>
											<div className="form-grouph submit-design text-center">
												<LoadingButton
													type="submit"
													loading={sending}
													className="pink-btn-design"
													>
													SEND
												</LoadingButton>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div className="col-xl-4 col-lg-4 col-md-4 col-sm-12">
								<div className="column-contact-rght">		
									
									<h4 className="tel-h4">CALL US</h4>
									<div className="contact-page-socials tel">
										
										<a href="tel:+1 512-489-6959"><span className="Social-contact-iCn"><i className="fas fa-phone-volume"></i></span> +1 512-489-6959</a>
									</div>
									
									<h4 className="tel-h4">FOLLOW US ON</h4>
									<div className="contact-page-socials">
										<a target="_blank" href={app.settings.instagram}><span className="Social-contact-iCn"><svg className="svg-inline--fa fa-instagram fa-w-14" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg></span> Instagram</a>
										<a target="_blank" href={app.settings.linkedin}><span className="Social-contact-iCn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></span> Linkedin</a>
										
										<a target="_blank" href={app.settings.tiktok} className="tiktok">
											<span className="Social-contact-iCn">
												<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="42px" height="42px" viewBox="0 0 2560 2560" preserveAspectRatio="xMidYMid meet">
												<g id="layer101" fill="#ed60bd" stroke="none">
												 <path d="M923 2125 c-241 -65 -403 -278 -403 -527 0 -154 49 -277 152 -384 103 -107 238 -164 390 -164 l88 0 0 144 0 144 -37 -10 c-20 -5 -57 -7 -82 -3 -134 20 -231 129 -231 258 0 93 17 135 80 197 62 63 105 80 196 80 72 0 127 -24 179 -75 78 -79 75 -44 75 -742 l0 -623 138 0 138 0 11 74 c12 89 56 187 109 246 58 64 137 98 267 115 l47 6 0 146 0 146 -82 -6 c-120 -9 -206 -36 -340 -105 -5 -2 -8 138 -8 310 0 248 -3 326 -15 373 -51 199 -201 349 -400 400 -73 19 -202 18 -272 0z"/>
												 </g>

												</svg>
											</span> Tiktok
										</a>
										
									</div>									
									
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
			
		</div>
		</Layout>
    );
};

export default Contact;