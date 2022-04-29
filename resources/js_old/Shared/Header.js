import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Modal from "react-modal";
import { Animated } from "react-animated-css";
import Moment from 'moment';
import MomentTz from 'moment-timezone';
import { ToastContainer, toast } from 'react-toastify';
// import 'react-toastify/dist/ReactToastify.css';
import CartSide from '@/Shared/CartSide';
import LoadingButton from '@/Shared/LoadingButton';
import TextInput from '@/Shared/TextInput';

Modal.setAppElement("#app");

export default ({setCartPopup, cartCount, cartPrice}) => {

	const current = route().current();
	const { props } = usePage();
	const { auth, errors, app } = props;
	const [cartOpened, setCartOpened] = useState(false);
	const [sending, setSending] = useState(false);
	const [countCart, setCountCart] = useState(0);
	
	const [modalType, setModalType] = useState('login');
	//---modal
	const [toggleModal, setToggleModal] = useState(false);
	const [storeHours, setStoreHours] = useState(false);
	
	let uuid = localStorage.getItem("uuid");
	let current_hour = MomentTz().tz('America/Chicago').format("HHmm");
	
	//...
	let start_time = app?.settings?.start_time;	
	let close_time = app?.settings?.close_time;
	
	let currentDay = MomentTz().tz('America/Chicago').format("dddd");	
	
	if(currentDay=='Thursday' || currentDay=='Friday' || currentDay=='Saturday'){
		start_time = app.settings.start_time_second;
		close_time = app.settings.close_time_second;
	}	
	
	start_time = Moment(start_time, 'HH:mm').format("HHmm");
	close_time = Moment(close_time, 'HH:mm').format("HHmm");
	
	//...
	useEffect(() => {
		fetchCartData();
		if(app.settings.store_online=='1' && (current_hour >= start_time || current_hour < close_time)){
			setStoreHours(true);
			if(app.settings.promocode_show=='1'){
				setModalType('promocode');
				setToggleModal(true);
			}
		}
		else {
			if(app.settings.store_modal=='1'){
				setModalType('offline');
				setToggleModal(true);
			}
		}

		if(auth.user && auth.user.status=='2'){
			logout();
		}

	}, [storeHours]);
	
	//---
	Inertia.on('finish', () => {
		if(current!='ucla'){
			fetchCartData();
		}
		if(auth.user){
			setToggleModal(false);
		}
		
		if(storeHours && localStorage.getItem('sidebar')=='opned'){
			if(auth.user){
				setCartOpened(true);
			}
		}
	});	
	
	async function fetchCartData() {
		try {
			if(countCart==0){
				let data = { uuid };
				await axios.get(route('cart.index', data)).then(res => {
					setCountCart(res.data.count);
				});
			}
		} catch (error) {
			setCountCart(0);
		}
	}
	
	
	const handleClick = (count) => {
		setCountCart(count);
		setCartOpened(false);
		localStorage.setItem('sidebar', 'closed');
	};
	function isCartOpen(){
		if(storeHours && cartCount>0){
			localStorage.setItem('sidebar', 'opned');
			setCartOpened(true);
		}
	}
	function isCartOpenOther(){
		if(storeHours && (cartCount>0 || countCart>0)){
			localStorage.setItem('sidebar', 'opned');
			setCartOpened(true);
		}
	}
	
	function logout() {
		localStorage.setItem("uuid", '');
		Inertia.post(route('userLogout')).then(() => {
			//
		});
	}
	
	
	
	function showModal(res) {
		setCartOpened(false);
		setModalType(res);
		setToggleModal(!toggleModal);
	}
	
	function closeModal() {
		setToggleModal(false);
		if(localStorage.getItem('sidebar')=='opned'){
			setCartOpened(true);
		}
	}
	
	//---login modal
	const [otpForm, setOtpForm] = useState(false);
	const [valuesLogin, setValuesLogin] = useState({
		phone_number: '',
		password: '',
		otp: '',
	});
	function handleChangeLogin(e) {
		const key = e.target.name;
		const value =
		e.target.type === 'checkbox' ? e.target.checked : e.target.value;

		setValuesLogin(valuesLogin => ({
			...valuesLogin,
			[key]: value
		}));
	}
	function handleSubmitLogin(e) {
		e.preventDefault();
		setSending(true);
		axios.post(route('signin.verify'), valuesLogin).then((res) => {
			if(res.data.type=='success'){
				if(res.data.otp){
					setOtpForm(true);
					setSending(false);
				}
				else {
					Inertia.post(route('signin.attempt'), valuesLogin).then(() => {
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
	
	//----signup modal
	const [valuesSignup, setValuesSignup] = useState({
		phone_number: '',
		password: '',
		password_confirmation: '',
		otp: ''
	});
	function handleChangeSignup(e) {
		const key = e.target.name;
		const value =
		e.target.type === 'checkbox' ? e.target.checked : e.target.value;

		setValuesSignup(valuesSignup => ({
			...valuesSignup,
			[key]: value
		}));
	}	
	function handleSubmitSignup(e) {
		e.preventDefault();
		setSending(true);
		axios.post(route('signup.attempt'), valuesSignup).then((res) => {
			toast(res.data.message);
			setSending(false);
			if(res.data.type=='success'){
				setModalType('registerOtp')
			}
		});
	}
	
	function handleSubmitSignupOtp(e) {
		e.preventDefault();
		setSending(true);
		Inertia.post(route('signup.otp'), valuesSignup).then(() => {
			setSending(false);
		});
	}
	
	
	//----forgot modal
	const [otpField, setOtpField] = useState('forgot');
	const [valuesForgot, setValuesForgot] = useState({
		phone_number: '',
		otp: '',
		password: '',
		password_confirmation: '',
	});
	function handleChangeForgot(e) {
		const key = e.target.name;
		const value =
		e.target.type === 'checkbox' ? e.target.checked : e.target.value;

		setValuesForgot(valuesForgot => ({
			...valuesForgot,
			[key]: value
		}));
	}	
	function handleSubmitForgot(e) {
		e.preventDefault();
		setSending(true);
		valuesForgot['type'] = otpField;
		axios.post(route('password'), valuesForgot).then((res) => {
			toast(res.data.message);
			setSending(false);
			if(res.data.type=='success'){
				if(otpField=='forgot'){
					setOtpField('otp');
				}
				if(otpField=='otp'){
					setOtpField('password');
				}
				if(otpField=='password'){
					setModalType('login');
				}
			}
			
		});
	}
	
	//...
	function resendOtp() {
		let values = valuesLogin;
		if(modalType=='forgot'){
			values = valuesForgot;
		}
		if(modalType=='register'){
			values = valuesSignup;
		}
		
		axios.post(route('resend.otp'), values).then((res) => {
			toast(res.data.message);
		});
	}
	

	
	
	
	
	return (
		<header id="main-header" className={`${current=='home' ? 'header-absolute' : 'relative-header'}`}>
			<div className="header-logo text-center">
			
				<InertiaLink href={route('home')} className={`${current=='home' ? 'white' : 'pink'}`}>
					<img src="/images/logo.png"></img>
					{current=='ucla' &&
						<span className="logo-text">University of Texas at Austin</span>
					}
				</InertiaLink>
			</div>
			
			<div className={`navigation-wrapper ${auth.user ? 'valid' : 'not-valid'}`}>
				<ul className={`list-unstyled justify-cntnt-end ${current=='home' ? 'white' : 'pink'}-text`}>
					
					{!auth.user &&
					<li className="login">
						{current=='ucla' &&
							<span onClick={() => showModal('login')}>Login</span>
						}
						{current!='ucla' &&
							<InertiaLink href={route('signin')}>Login</InertiaLink>
						}
					</li>
					}
					
					{auth.user &&
					<li className="dashboard">
						<div className="dashboard-btn">
						<InertiaLink href={route('home')} className="favourite">
						<span className="dashboard-icn"><i className="fas fa-home"></i></span>
						</InertiaLink>
							
						</div>
					</li>
					}
					
					{auth.user &&
					<li className="cart-wrapper">
						<div className="dropdown">
							<button className="dashboard-btn" type="button" data-toggle="dropdown">
								<span className="dashboard-icn"><i className="fas fa-user"></i></span>
							</button>
							<div className="dropdown-menu">
								{auth.user.role=='user' &&
									<>
									<InertiaLink href={route('profile')} className="dropdown-item my-account">
										My Account
									</InertiaLink>
									<InertiaLink href={route('change.password')} className="dropdown-item change-password">
										Change Password
									</InertiaLink>
									<InertiaLink href={route('orders')} className="dropdown-item my-orderes">
										My Orders
									</InertiaLink>
									<a href="#" onClick={()=>logout()} className="dropdown-item logout">
										Logout
									</a>
									</>
								}
								
								{auth.user.role=='admin' &&
									<a className="dropdown-item my-account" href={route('admin')}>Dashboard</a>
								}
								{auth.user.role=='store' &&
									<a className="dropdown-item my-account" href={route('store')}>Store</a>
								}
							</div>
						</div>
					</li>
					}
					<li className="cart-wrapper">
						<InertiaLink href={route('favourite')} className="favourite">
							<span className="cart-icn"><i className="fas fa-heart"></i></span>
						</InertiaLink>
						
						{current=='ucla' &&
							<a href="#" onClick={() => isCartOpen()}>
								<span className="cart-icn"><i className="fas fa-shopping-bag"></i></span>
								{cartCount>0 &&
									<span className="product-value">{cartCount}</span>
								}
							</a>
						}
						
						{current!='ucla' &&
							<a href="#" onClick={() => isCartOpenOther()}>
								<span className="cart-icn"><i className="fas fa-shopping-bag"></i></span>
								{countCart>0 &&
									<span className="product-value">{countCart}</span>
								}
							</a>
						}
					</li>
					
				</ul>
			</div>
		 
			<CartSide cartOpened={cartOpened} handleClick={handleClick} showModal={showModal} setCartPopup={setCartPopup}/>
			
			<Modal
				isOpen={toggleModal}
				onRequestClose={()=>closeModal()}
				contentLabel={modalType}
				className="mymodal"
				overlayClassName={`myoverlay${modalType=='offline'?' storeclosed-offine':''}`}
				closeTimeoutMS={500}
				>
				<div className="container">
					{modalType=='login' &&
					<Animated animationIn="fadeInLeft" animationOut="fadeOutRight" animationInDuration={1000} animationOutDuration={1000} isVisible={modalType=='login' ? true : false}>
					<form onSubmit={handleSubmitLogin} id="login-form">
						
						{!otpForm &&
						<>
						<div className="form-grouph form-heading text-center">
							<span onClick={()=>closeModal()} className="pull-right">x</span>
							<h2>login</h2>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Phone Number"
								name="phone_number"
								type="number"
								value={valuesLogin.phone_number}
								errors={errors.phone_number}
								onChange={handleChangeLogin}
								/>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Password"
								name="password"
								type="password"
								value={valuesLogin.password}
								errors={errors.password}
								onChange={handleChangeLogin}
								/>
						</div>
						<div className="form-grouph forget-password text-right">
							<a href="#" onClick={() => setModalType('forgot')}>Forget Password?</a>
						</div>
						</>
						}
						
						{otpForm &&
						<>
						<div className="form-grouph form-heading text-center">
							<span onClick={()=>closeModal()} className="pull-right">x</span>
							<h2>OTP Code</h2>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Code"
								name="otp"
								type="number"
								value={valuesLogin.otp}
								errors={errors.otp}
								onChange={handleChangeLogin}
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
								{otpForm ? 'Verification Code' : 'Login' }
							</LoadingButton>
						</div>
						<div className="form-grouph signup-text text-center">
							<p>New to Shmacked? 
								<a href="#" onClick={() => setModalType('register')}> Sign Up</a>
							</p>
						</div>
					</form>
					</Animated>
					}					
					
					
					{modalType=='register' &&
					<Animated animationIn="fadeInLeft" animationOut="fadeOutRight" animationInDuration={1000} animationOutDuration={1000} isVisible={modalType=='register' ? true : false}>
					<form onSubmit={handleSubmitSignup} id="login-form">
						<div className="form-grouph form-heading text-center">
							<span onClick={()=>closeModal()} className="pull-right">x</span>
							<h2>Sign Up</h2>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Phone Number"
								name="phone_number"
								type="number"
								value={valuesSignup.phone_number}
								errors={errors.phone_number}
								onChange={handleChangeSignup}
								/>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Password"
								name="password"
								type="password"
								value={valuesSignup.password}
								errors={errors.password}
								onChange={handleChangeSignup}
								/>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Confirm Password"
								name="password_confirmation"
								type="password"
								value={valuesSignup.password_confirmation}
								errors={errors.password_confirmation}
								onChange={handleChangeSignup}
								/>
						</div>
						<div className="form-grouph submit-design text-center margin-auto">
							<LoadingButton
								type="submit"
								loading={sending}
								className="pink-btn-design"
								>
								Sign Up
							</LoadingButton>
						</div>
						<div className="form-grouph signup-text text-center">
							<p>Already Joined?
								<a href="#" onClick={() => setModalType('login')}> Login</a>
							</p>
						</div>
					</form>
					</Animated>
					}
					
					
					{modalType=='registerOtp' &&
					<Animated animationIn="fadeInLeft" animationOut="fadeOutRight" animationInDuration={1000} animationOutDuration={1000} isVisible={modalType=='registerOtp' ? true : false}>
					<form onSubmit={handleSubmitSignupOtp} id="login-form">
						<div className="form-grouph form-heading text-center">
							<span onClick={()=>closeModal()} className="pull-right">x</span>
							<h2>Verification Code</h2>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Code"
								name="otp"
								type="number"
								value={valuesSignup.otp}
								errors={errors.otp}
								onChange={handleChangeSignup}
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
					</Animated>
					}
					
					
					{modalType=='forgot' &&
					<Animated animationIn="fadeInLeft" animationOut="fadeOutRight" animationInDuration={1000} animationOutDuration={1000} isVisible={true}>
					<form onSubmit={handleSubmitForgot} id="login-form">
						<div className="form-grouph form-heading text-center">
							<span onClick={()=>closeModal()} className="pull-right">x</span>
							<h2>
								{otpField=='forgot' && 'Forgot Password'}
								{otpField=='otp' && 'Verification Code'}
								{otpField=='password' && 'Change Password'}
							</h2>
						</div>
						{otpField=='forgot' &&
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Phone Number"
								name="phone_number"
								type="number"
								value={valuesForgot.phone_number}
								errors={errors.phone_number}
								onChange={handleChangeForgot}
								/>
						</div>
						}
						
						{otpField=='otp' &&
						<>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Code"
								name="otp"
								type="number"
								value={valuesForgot.otp}
								errors={errors.otp}
								onChange={handleChangeForgot}
								/>
						</div>
						<a href="javascript:void(0)" className="resendOtp" onClick={() => resendOtp()}>Resend Code</a>
						</>
						}
						
						{otpField=='password' &&
						<>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Password"
								name="password"
								type="password"
								value={valuesForgot.password}
								errors={errors.password}
								onChange={handleChangeForgot}
								/>
						</div>
						<div className="form-grouph input-design">
							<TextInput
								placeholder="Confirm Password"
								name="password_confirmation"
								type="password"
								value={valuesForgot.password_confirmation}
								errors={errors.password_confirmation}
								onChange={handleChangeForgot}
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
								<a href="#" onClick={() => setModalType('login')}> Login</a>
							</p>
						</div>
					</form>
					</Animated>
					}
					
					{(!storeHours && modalType=='offline') &&
					<div className="shop-closed-popup" id="shop-closed">
						<div className="modal-content">
							<button type="button" className="close" onClick={()=>closeModal()}>X</button>
							<div className="modal-body" style={{backgroundImage: "url(" + "images/store-bg-shape.png" + ")"}}>
								<div className="popup-inner-cntnt">
									<h4 className="Store-popup-heading">Store is Closed</h4>
									<p>{app.settings.store_offline_message}</p>
								</div>
							</div>
						</div>
					</div>
					}
					
					{(storeHours && modalType=='promocode') &&
					<div className="shop-closed-popup promocode" id="shop-closed">
					<div className="modal-content">
							<button type="button" className="close" onClick={()=>closeModal()}>X</button>
							<div className="modal-body" style={{backgroundImage: "url(" + "images/store-bg-shape.png" + ")"}}>
								<div className="popup-inner-cntnt">
									<h4 className="Store-popup-heading">{app.settings.promocode_text} <span className="code">{app.settings.promocode}</span></h4>
									<p>{app.settings.promocode_message}</p>
								</div>
							</div>
						</div>
					</div>
					}
					
					
				</div>
			</Modal>
			
			
			{(storeHours && cartCount>0 && (current=='ucla' || current=='favourite')) &&
			<div id="cart-popup">
				<div className="black-cart-poup">
					<div className="items-counter">
						<p><span className="item-number">{cartCount}</span> Items</p>
					</div>
					<div className="view-bag">
						<span className="View-bag" onClick={() => isCartOpenOther()}>View Bag</span>
					</div>
					<div className="price-box-xntnt">
						<a className="price-small" href="#">${cartPrice}</a>
					</div>
				</div>
			</div>
			}
			
		</header>
		
	);
};
