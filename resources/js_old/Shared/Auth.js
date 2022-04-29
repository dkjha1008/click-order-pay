import React, { useState } from 'react';
import Helmet from 'react-helmet';
import { InertiaProgress } from '@inertiajs/progress';
import { usePage } from '@inertiajs/inertia-react';

import AuthHeader from '@/Shared/AuthHeader';
import Footer from '@/Shared/Footer';
import FlashMessages from '@/Shared/FlashMessages';

export default function Auth({ children }) {
	const { props } = usePage();
	const { app } = props;
	
	InertiaProgress.init({
		color: '#ed60bd',
		includeCSS: true,
		showSpinner: true,
	});
	
	return (
		<div>
			<Helmet titleTemplate={`%s | ${app.name}`} />
			
			<AuthHeader />
			<FlashMessages />
			{children}
			<Footer />
		</div>
	);
}