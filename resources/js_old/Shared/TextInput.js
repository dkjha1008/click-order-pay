import React from 'react';

export default ({ label, name, type, className, error=true, errors = [], ...props }) => {
  return (
    <>
      {label && (
        <label className="form-label" htmlFor={name}>
          {label}:
        </label>
      )}
      <input
		type={type}
        name={name}
        {...props}
        className={`${errors.length ? 'error' : ''}`}
      />
	  {(error && errors) && <div className="form-error">{errors[0]}</div>}
    </>
  );
};
