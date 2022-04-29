import React, { useState } from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Modal from "react-modal";
import { scroller } from 'react-scroll';
Modal.setAppElement("#app");

export default () => {
	const { props } = usePage();
	const { app } = props;
	//---modal
	
	function scrollTop() {
		scroller.scrollTo('main-header', {
			duration: 2000,
			delay: 2,
			smooth: "easeInOutQuart",
		});
	}
	
	
	return (
		<footer id="main-footer">
			<div id="scroll-top">
			<a href="javascript:void(0)" onClick={() => scrollTop()}><i className="fas fa-angle-up"></i></a>
			</div>
			<div className="container">
				<div className="footer-flex">
					<div className="footer-flex-div">
						<div className="footer-column footer-column-1 text-center">
							<div className="footer-logo">
								<InertiaLink href={route('home')}>
								<img src="images/logo.png"></img>
								</InertiaLink>
								<p>Delivery in Less than 15 minutes</p>
							</div>
							<div className="footer-social-icons">
								<a target="_blank" href={app?.settings?.instagram} className="footer-icon"><i className="fab fa-instagram"></i></a>
								<a target="_blank" href={app?.settings?.linkedin} className="footer-icon"><i className="fab fa-linkedin"></i></a>
								<a target="_blank" href={app?.settings?.tiktok} className="footer-icon tiktok">
									<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="42px" height="42px" viewBox="0 0 2560 2560" preserveAspectRatio="xMidYMid meet">
									<g id="layer101" fill="#000000" stroke="none">
									 <path d="M923 2125 c-241 -65 -403 -278 -403 -527 0 -154 49 -277 152 -384 103 -107 238 -164 390 -164 l88 0 0 144 0 144 -37 -10 c-20 -5 -57 -7 -82 -3 -134 20 -231 129 -231 258 0 93 17 135 80 197 62 63 105 80 196 80 72 0 127 -24 179 -75 78 -79 75 -44 75 -742 l0 -623 138 0 138 0 11 74 c12 89 56 187 109 246 58 64 137 98 267 115 l47 6 0 146 0 146 -82 -6 c-120 -9 -206 -36 -340 -105 -5 -2 -8 138 -8 310 0 248 -3 326 -15 373 -51 199 -201 349 -400 400 -73 19 -202 18 -272 0z"/>
									 </g>
									</svg>
								</a>
							</div>
						</div>
					</div>
					<div className="footer-flex-div">
						<div className="footer-column footer-column-2">
							<h2>STORE</h2>
							<ul>
								<li><InertiaLink href={route('currentLocation')}>Current Locations</InertiaLink></li>
								<li><InertiaLink href={route('storeHours')}>Store Hours</InertiaLink></li>
								<li><InertiaLink href={route('contact')}>Contact Us</InertiaLink></li>
							</ul>
						</div>
					</div>
					<div className="footer-flex-div">
						<div className="footer-column footer-column-3">
							<h2>COMPANY</h2>
							<ul>
								<li><InertiaLink href={route('about')}>About Us</InertiaLink></li>
								<li><InertiaLink href={`${route('about')}#mission`}>Mission</InertiaLink></li>
								<li><InertiaLink href={route('joinus')}>Join Us</InertiaLink></li>
							</ul>
						</div>
					</div>
					<div className="footer-flex-div">
						<div className="footer-column footer-column-4">
							<h2>RESOURCES</h2>
							<ul>
								<li><a target="_blank" href={`${app.url}SHMACKED-PRIVACY-POLICY.pdf`}>Privacy Policy</a></li>
								<li><a target="_blank" href={`${app.url}SHMACKED-TERMS.pdf`}>Terms</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div className="copyRight-text text-center">
					<p>© ClickOrderPay All rights reserved 2020. Website designed by ATX Web Designs.</p>
				</div>
			</div>
			
		</footer>
	);
};