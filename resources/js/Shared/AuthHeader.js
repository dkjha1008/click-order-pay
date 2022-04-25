import React, { useState } from 'react';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';

export default () => {
	const { props } = usePage();
	const { app } = props;
	
	return (
		<header id="main-header" className="relative-header">
			<div className="header-logo text-center">
				<InertiaLink href={route('home')} className="pink">
					{app.name}
				</InertiaLink>
			</div>
		</header>
	);
};
