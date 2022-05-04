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
			<Helmet title="ClickOrderPay  - UT Austin's Fastest Delivery Service" />
			
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
												{stores?.length>0 && stores.map((store, key) => {
													
                                                return (<option value={store?.slug} key={key}>{store?.title}</option>)
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
					</div>
				</section>
			</main>
		</div>
    );
};

Home.layout = page => <Layout children={page} />;

export default Home;