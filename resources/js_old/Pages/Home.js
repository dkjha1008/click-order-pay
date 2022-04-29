import React, { useState, useRef, useEffect } from 'react';
import Helmet from 'react-helmet';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';
import Layout from '@/Shared/Layout';


const Home = () => {
    const [display,setDisplay]  = useState(false);
	const [options, setOptions] = useState([]);
	const [search,setSearch]    = useState("");
	const { props } = usePage();
	const { category, app, stores } = props;
	const wrapperRef = useRef(null);

	useEffect(()=>{
		setOptions(stores);
		console.log(options);

	},[])

	const setPokeDex = poke => {
		setSearch(poke);
		setDisplay(false);
	}
	
    return (
		<div>
			<Helmet title="Shmacked - UT Austin's Fastest Delivery Service" />
			
			<main className="main-content">				
				<section className="header-gredient-cntnt" style={{backgroundImage: "url(" + "images/gredient-bg.png" + ")"}}>
					<div className="container">
						<div className="header-cntnt-wrapper">
							<h2>Delivery in less than 15 minutes</h2>
							<div className="hdr-form-box">
								<form action="/shop" method="get">
									<div className="form-flex">
									 	<div className="form-grouph select-design">
											 {/* <input id="auto" onClick={()=>setDisplay(!display)} 
											   placeholder="Type to search" 
											   value={search}
											   onChange={(e) => setSearch(e.target.value)}
											   />
											 {display && (
												 <div className="autoContainer" >
													 {options.filter(({name})=> name.indexOf(search.toLowerCase()) > -1).map((v,i)=>{
														 return <div onClick={() => setPokeDex(v.name)} className="option" key={i}>
															 <span>{v.name}</span>
														 </div>
													 })}
												 </div>
											 )} */}
											<select name="store" required>
												<option value="">--Select Store--</option>
												{stores.length>0 && stores.map((store, key) => {
													
                                                return (<option value={store.slug}>{store?.title}</option>)
												})}
											</select>
											
										</div>
										<div className="form-grouph submit-design">
											<input type="submit" className="black-btn-design" value="GO"/>
											{/* <InertiaLink href={route('ucla')}>GO</InertiaLink> */}
										</div>
									</div>
									<InertiaLink href={route('ucla')} className="browse-text">or browse our selection</InertiaLink>
								</form>
							</div>
						</div>
						<div className="category-wrapper">
							<div className="categor-heading">
								<h2>SELECT A CATEGORY</h2>
							</div>
							<div className="row">
								
								{category.length>0 && category.map((cat, key) => {
								let image = 'storage/category/' + cat?.image;
								
								let url = route('ucla') + '?category=' + cat?.slug;
								return(
									<div className="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-4" key={key}>
										<InertiaLink href={url} className="white-icon-box">
											<div className="icon-img" style={{backgroundImage: "url(" + image + ")"}}>
											</div>
											<div className="icon-cntnt">
												<h5>{cat?.name}</h5>
											</div>
											</InertiaLink>
									</div>
									);
								})}
							</div>
							<div className="category-buttons">
								<InertiaLink href={route('ucla')} className="btn pink-btn-design">SEE ALL PRODUCTS
								</InertiaLink>
							</div>
						</div>
					</div>
				</section>
				<section className="delivery-time-wrapper" style={{backgroundImage: "url(" + "images/pink-bg.png" + ")"}}>
					<div className="container">
						<div className="row align-items-center">
							<div className="col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div className="delivery-cntnt">
									<div className="delivery-cntnt-one">
										<p>Our Average Delivery Time</p>
										<h2>{app?.settings?.delivery_time}</h2>
									</div>
									<div className="delivery-cntnt-scnd">
										<p>Students Served</p>
										<h2>{app?.settings?.students_served}</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
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
									<p>We’re a UT startup that thrives on the values of time, convenience, and a college party lifestyle. For that we created Shmacked, a delivery service that gets you anything from snacks to puffs in less than 15 minutes!</p>
									<a className="black-btn-design" href={route('applyNow')}>APPLY NOW</a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</main>
		</div>
    );
};

Home.layout = page => <Layout children={page} />;

export default Home;