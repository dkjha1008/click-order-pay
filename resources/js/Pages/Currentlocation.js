import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import Moment from 'moment';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Footer from '@/Shared/Footer';

const Currentlocation = () => {
	const { props } = usePage();
	const { app } = props;
	
    return (
		<div>
			<Helmet title={`Current Locations | ${app.name}`}/>
			
			<div className="storeloc curr" style={{backgroundImage: "url(" + "images/store.hd.JPG" + ")"}}>
				<main className="main-content">
					<div className="container">
						<div className="order-hitory max-1140">
							
							<div className="header-logo text-center">
								<InertiaLink href={route('home')} className="white">
									{app.name}
								</InertiaLink>
							</div>
			
							<div className="order-histor-heading">
								<h4>CURRENT LOCATIONS</h4>
								<h1>Where we deliver.</h1>
							</div>
							
						</div>
					</div>					
					
				</main>
			</div>
			
			<div className="google-map-code">
				<iframe src="https://www.google.com/maps/d/embed?mid=1LJidjyGYBMwAQzh9AeNv1Mz6c7A1fQbL" width="100%" height="480"></iframe>
			</div>
			
			<Footer />
		</div>
    );
};

export default Currentlocation;