import React, { useState, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';

const About = () => {

	
    return (
		<Layout>
		<div>
			<Helmet title="About Us" />
			
			<main className="main-content">
				<section className="about-main-sec">
					<div className="container">
						<div className="row">
							<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div className="about-us-text">
									<h2>About Us</h2>
									<p>If your reading this you probably already know Shmacked delivers college students’ favorite snacks, drinks, and essentials in less than 15 minutes. Yea we’re the fastest delivery service ever, but Shmacked is so much more.
									Take if from the definition of our name:</p>
								</div>
							</div>
							<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div className="about-quote-text">
									<p>“a state of immense enjoyment, amusement, and lighthearted pleasure”</p>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section className="our-vision-main-sec" style={{backgroundImage: "url(" + "images/about-gredient-bg.png" + ")"}}>
					<div className="container">
						<div className="row">
							<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div className="vision-lft-txt">
									<p>
									Shmacked is all about the amazing experiences of an eccentric college lifestyle. We here at Shmacked are college students just like you and know that this is one of the most fun and crazy times of your life. For that reason, we’d decided to make having an amazing college experience that much easier. Shmacked is all about energy, excitement, and entertainment. College is a once-in-a-lifetime opportunity and we wanna help you make the most of it through our convenient delivery, dope merch, and sponsored events. So even though it is the fastest delivery service out there, Shmacked began with a vision. A vision that a college experience only comes once, so why not enjoy every second of it.
									</p>
									<div className="our-vision-box">
										<h2 id="mission">our mission</h2>
										<p>“To empower students to enjoy every second of their college experience.”</p>
									</div>
								</div>
							</div>
							<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								
							</div>
						</div>
					</div>
				</section>
				<section className="our-values-sec">
					<div className="container">
						<div className="value-heading">
							<h2>our family</h2>
						</div>
						
					</div>
				</section>
			</main>
			
		</div>
		</Layout>
    );
};

export default About;