import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';

import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';

const Joinus = () => {

    return (
		<Layout>
		<div>
			<Helmet title="Join Us" />
			
			<main className="main-content">
			<div className="joinus-page">
				<div className="container">
					<div className="order-hitory">
						<div className="order-histor-heading">
							<h2>Join Us</h2>
						</div>
						<div className="paragraph-text-block">

							<p>Shmacked is dedicated to providing college students with quick essentials delivered directly to their doorstep. It is our goal to bring students joy by supplying anything they need within 15 minutes while connecting with other college students in the community.</p>
							<p>Our Shmacked family fosters a positive, uplifting environment where everyone’s perspectives are heard. We encourage and empower each other to bring innovative ideas to the table and are constantly welcoming suggestions and improvements. As students, we aim to ensure that our fellow students feel special and satisfied with our quick delivery service.</p>
							<p>Interested in becoming a Rider? We would love for you to join the family. Go to our ‘Contact Us’ page to find out more about how to get an application.</p>

						</div>
					</div>
					<section className="become-rider-sec">
					<div className="container">
						<div className="row align-items-center">
							<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div className="rider-img">
									<img src="images/become-rider.webp"/>
								</div>
							</div>
							<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div className="heading-paragraph-design">
									<h2>Become a Rider</h2>
									<p>As a Shmacked Rider, you'll have the opportunities to create a flexible schedule, bond with fellow students, and earn paychecks for riding around really fast! What's not to love?</p>
									<a className="black-btn-design" href={route('applyNow')}>APPLY NOW</a>
								</div>
							</div>
						</div>
					</div>
				</section>
				</div>
				</div>
			</main>
			
		</div>
		</Layout>
    );
};

export default Joinus;