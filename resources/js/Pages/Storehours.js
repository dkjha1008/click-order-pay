import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import Moment from 'moment';
import MomentTz from 'moment-timezone';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Footer from '@/Shared/Footer';

const Storehours = () => {
	const { props } = usePage();
	const { app } = props;
	
	let start_time = app.settings.start_time;
	let close_time = app.settings.close_time;
	
	let currentDay =MomentTz().tz('America/Chicago').format("dddd");
	
	if(currentDay=='Thursday' || currentDay=='Friday' || currentDay=='Saturday'){
		start_time = app.settings.start_time_second;
		close_time = app.settings.close_time_second;
	}	
	
	start_time = Moment(start_time, 'HH:mm').format("h:mm A");
	close_time = Moment(close_time, 'HH:mm').format("h:mm A");
	
	let store_time = start_time +' - '+ close_time;

    return (
		<div>
			<Helmet title={`Store Hours | ${app.name}`}/>
			
			<div className="storeloc" style={{backgroundImage: "url(" + "images/store.hd.JPG" + ")"}}>
				<main className="main-content">
					<div className="container">
						<div className="order-hitory max-1140">
							
							<div className="header-logo text-center">
								<InertiaLink href={route('home')} className="white">
									{app.name}
								</InertiaLink>
							</div>
			
							<div className="order-histor-heading">
								<h2>STORE HOURS</h2>
							</div>
							{store_time}
						</div>
					</div>
				</main>
			</div>
			<Footer />
		</div>
    );
};

export default Storehours;