import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import md5 from 'md5';
import { InertiaProgress } from '@inertiajs/progress';

import Header from '@/Shared/Header';
import Footer from '@/Shared/Footer';
import { usePage } from '@inertiajs/inertia-react';
import FlashMessages from '@/Shared/FlashMessages';

export default function Layout({ children, setCartPopup, cartCount=0, cartPrice=0 }) {

	const { props } = usePage();
	const { app } = props;
	InertiaProgress.init({
		color: '#ed60bd',
		includeCSS: true,
		showSpinner: true,
	});	
	
	const current = route().current();
	
	useEffect(() => {
		if(current!='ucla'){
			localStorage.setItem('sidebar', 'closed');
		}
	}, []);
	
	
	//set uuid
	if(!localStorage.getItem("uuid")){
		let uuid = md5(new Date());
		localStorage.setItem("uuid", uuid);
	}


	let title = `%s | ${app.name}`;
	if(current=='home' || current=='ucla'){
		title = `%s`;
	}

	
	return (
		<div>
			<Helmet titleTemplate={title} />
			
			<Header setCartPopup={setCartPopup} cartCount={cartCount} cartPrice={cartPrice}/>
			<FlashMessages />
			{children}
			<Footer />
		</div>
	);
}