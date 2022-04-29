import React, { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/inertia-react';
import classNames from 'classnames';

import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


export default () => {
	const { props } = usePage();
	const { flash, errors } = props;
	const numOfErrors = Object.keys(errors).length;

	useEffect(() => {
		if(flash.success){
			toast(flash.success);
		}
		if(flash.error){
			toast(flash.error);
		}
		// if(numOfErrors === 1){
			// toast('There is one form error');
		// }
		// if(numOfErrors > 1){
			// toast(`There are ${numOfErrors} form errors`);
		// }		
	}, [flash, errors]);
	
	//const notify = () => toast("Wow so easy !");
	
	return (
		<ToastContainer autoClose={10000}/>
	);
};
