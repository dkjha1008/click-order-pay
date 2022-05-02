(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[10],{

/***/ "./resources/js/Pages/Auth/Signin.js":
/*!*******************************************!*\
  !*** ./resources/js/Pages/Auth/Signin.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var react_helmet__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-helmet */ \"./node_modules/react-helmet/es/Helmet.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! axios */ \"./node_modules/axios/index.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @inertiajs/inertia */ \"./node_modules/@inertiajs/inertia/dist/index.js\");\n/* harmony import */ var _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @inertiajs/inertia-react */ \"./node_modules/@inertiajs/inertia-react/dist/index.js\");\n/* harmony import */ var _inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var react_toastify__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react-toastify */ \"./node_modules/react-toastify/dist/react-toastify.esm.js\");\n/* harmony import */ var _Shared_Auth__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @/Shared/Auth */ \"./resources/js/Shared/Auth.js\");\n/* harmony import */ var _Shared_LoadingButton__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @/Shared/LoadingButton */ \"./resources/js/Shared/LoadingButton.js\");\n/* harmony import */ var _Shared_TextInput__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @/Shared/TextInput */ \"./resources/js/Shared/TextInput.js\");\nfunction ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }\n\nfunction _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }\n\nfunction _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }\n\nfunction _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }\n\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\nfunction _iterableToArrayLimit(arr, i) { if (typeof Symbol === \"undefined\" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i[\"return\"] != null) _i[\"return\"](); } finally { if (_d) throw _e; } } return _arr; }\n\nfunction _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }\n\n\n\n\n\n\n // import 'react-toastify/dist/ReactToastify.css';\n\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (function () {\n  var _usePage = Object(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_4__[\"usePage\"])(),\n      props = _usePage.props;\n\n  var errors = props.errors,\n      app = props.app;\n\n  var _useState = Object(react__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])(false),\n      _useState2 = _slicedToArray(_useState, 2),\n      sending = _useState2[0],\n      setSending = _useState2[1];\n\n  var _useState3 = Object(react__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])(false),\n      _useState4 = _slicedToArray(_useState3, 2),\n      otpForm = _useState4[0],\n      setOtpForm = _useState4[1];\n\n  var _useState5 = Object(react__WEBPACK_IMPORTED_MODULE_0__[\"useState\"])({\n    phone_number: '',\n    password: '',\n    otp: ''\n  }),\n      _useState6 = _slicedToArray(_useState5, 2),\n      values = _useState6[0],\n      setValues = _useState6[1];\n\n  function handleChange(e) {\n    var key = e.target.name;\n    var value = e.target.type === 'checkbox' ? e.target.checked : e.target.value;\n    setValues(function (values) {\n      return _objectSpread(_objectSpread({}, values), {}, _defineProperty({}, key, value));\n    });\n  }\n\n  function handleSubmit(e) {\n    e.preventDefault();\n    setSending(true);\n    axios__WEBPACK_IMPORTED_MODULE_2___default.a.post(route('signin.verify'), values).then(function (res) {\n      if (res.data.type == 'success') {\n        if (res.data.otp) {\n          setOtpForm(true);\n          setSending(false);\n        } else {\n          _inertiajs_inertia__WEBPACK_IMPORTED_MODULE_3__[\"Inertia\"].post(route('signin.attempt'), values).then(function () {\n            setSending(false);\n          });\n        }\n      } else {\n        setSending(false);\n        Object(react_toastify__WEBPACK_IMPORTED_MODULE_5__[\"toast\"])(res.data.message);\n      }\n    });\n  } //...\n\n\n  function resendOtp() {\n    axios__WEBPACK_IMPORTED_MODULE_2___default.a.post(route('resend.otp'), values).then(function (res) {\n      Object(react_toastify__WEBPACK_IMPORTED_MODULE_5__[\"toast\"])(res.data.message);\n    });\n  }\n\n  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_Auth__WEBPACK_IMPORTED_MODULE_6__[\"default\"], null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react_helmet__WEBPACK_IMPORTED_MODULE_1__[\"default\"], {\n    title: \"Login\"\n  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"main\", {\n    className: \"main-content\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"authentication-page-wrapper max-562\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"container\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"form\", {\n    onSubmit: handleSubmit,\n    id: \"login-form\"\n  }, !otpForm && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph form-heading text-center\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"h2\", null, \"login\")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph input-design\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_TextInput__WEBPACK_IMPORTED_MODULE_8__[\"default\"], {\n    placeholder: \"Email/ Phone Number\",\n    name: \"phone_number\",\n    type: \"number\",\n    value: values.phone_number,\n    errors: errors.phone_number,\n    onChange: handleChange\n  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph input-design\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_TextInput__WEBPACK_IMPORTED_MODULE_8__[\"default\"], {\n    placeholder: \"Password\",\n    name: \"password\",\n    type: \"password\",\n    value: values.password,\n    errors: errors.password,\n    onChange: handleChange\n  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph forget-password text-right\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_4__[\"InertiaLink\"], {\n    href: route('forgot')\n  }, \"Forgot Password?\"))), otpForm && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph form-heading text-center\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"h2\", null, \"Verification Code\")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph input-design\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_TextInput__WEBPACK_IMPORTED_MODULE_8__[\"default\"], {\n    placeholder: \"Code\",\n    name: \"otp\",\n    type: \"number\",\n    value: values.otp,\n    errors: errors.otp,\n    onChange: handleChange\n  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"a\", {\n    href: \"javascript:void(0)\",\n    className: \"resendOtp\",\n    onClick: function onClick() {\n      return resendOtp();\n    }\n  }, \"Resend Code\")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph submit-design text-center margin-auto\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_LoadingButton__WEBPACK_IMPORTED_MODULE_7__[\"default\"], {\n    type: \"submit\",\n    loading: sending,\n    className: \"pink-btn-design\"\n  }, otpForm ? 'Verify OTP' : 'Login')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"form-grouph signup-text text-center\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"p\", null, \"New to \", app.name, \"?\", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_4__[\"InertiaLink\"], {\n    href: route('signup')\n  }, \" Sign Up\")))))))));\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvUGFnZXMvQXV0aC9TaWduaW4uanM/ZmRjMiJdLCJuYW1lcyI6WyJ1c2VQYWdlIiwicHJvcHMiLCJlcnJvcnMiLCJhcHAiLCJ1c2VTdGF0ZSIsInNlbmRpbmciLCJzZXRTZW5kaW5nIiwib3RwRm9ybSIsInNldE90cEZvcm0iLCJwaG9uZV9udW1iZXIiLCJwYXNzd29yZCIsIm90cCIsInZhbHVlcyIsInNldFZhbHVlcyIsImhhbmRsZUNoYW5nZSIsImUiLCJrZXkiLCJ0YXJnZXQiLCJuYW1lIiwidmFsdWUiLCJ0eXBlIiwiY2hlY2tlZCIsImhhbmRsZVN1Ym1pdCIsInByZXZlbnREZWZhdWx0IiwiYXhpb3MiLCJwb3N0Iiwicm91dGUiLCJ0aGVuIiwicmVzIiwiZGF0YSIsIkluZXJ0aWEiLCJ0b2FzdCIsIm1lc3NhZ2UiLCJyZXNlbmRPdHAiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtDQUVBOztBQUNBO0FBQ0E7QUFFQTtBQUVlLDJFQUFNO0FBQUEsaUJBQ0ZBLHdFQUFPLEVBREw7QUFBQSxNQUNaQyxLQURZLFlBQ1pBLEtBRFk7O0FBQUEsTUFFWkMsTUFGWSxHQUVJRCxLQUZKLENBRVpDLE1BRlk7QUFBQSxNQUVKQyxHQUZJLEdBRUlGLEtBRkosQ0FFSkUsR0FGSTs7QUFBQSxrQkFHVUMsc0RBQVEsQ0FBQyxLQUFELENBSGxCO0FBQUE7QUFBQSxNQUdiQyxPQUhhO0FBQUEsTUFHSkMsVUFISTs7QUFBQSxtQkFJVUYsc0RBQVEsQ0FBQyxLQUFELENBSmxCO0FBQUE7QUFBQSxNQUliRyxPQUphO0FBQUEsTUFJSkMsVUFKSTs7QUFBQSxtQkFLUUosc0RBQVEsQ0FBQztBQUNwQ0ssZ0JBQVksRUFBRSxFQURzQjtBQUVwQ0MsWUFBUSxFQUFFLEVBRjBCO0FBR3BDQyxPQUFHLEVBQUU7QUFIK0IsR0FBRCxDQUxoQjtBQUFBO0FBQUEs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Q0FkQSxlQXdCQTtBQUFLLGFBQVMsRUFBQztBQUFmLGtCQUNDLDJEQUFDLG9FQUFEO0FBQWEsUUFBSSxFQUFFWSxLQUFLLENBQUMsUUFBRDtBQUF4Qix3QkFERCxDQXhCQSxDQUhELEVBaUNFbkIsT0FBTyxpQkFDUixxSUFDQTtBQUFLLGFBQVMsRUFBQztBQUFmLGtCQUNDLDJGQURELENBREEsZUFJQTtBQUFLLGFBQVMsRUFBQztBQUFmLGtCQUNDLDJEQUFDLHlEQUFEO0FBQ0MsZUFBVyxFQUFDLE1BRGI7QUFFQyxRQUFJLEVBQUMsS0FGTjtBQUdDLFFBQUksRUFBQyxRQUhOO0FBSUMsU0FBSyxFQUFFSyxNQUFNLENBQUNELEdBSmY7QUFLQyxVQUFNLEVBQUVULE1BQU0sQ0FBQ1MsR0FMaEI7QUFNQyxZQUFRLEVBQUVHO0FBTlgsSUFERCxDQUpBLGVBY0E7QUFBRyxRQUFJLEVBQUMsb0JBQVI7QUFBNkIsYUFBUyxFQUFDLFdBQXZDO0FBQW1ELFdBQU8sRUFBRTtBQUFBLGFBQU1tQixTQUFTLEVBQWY7QUFBQTtBQUE1RCxtQkFkQSxDQWxDRCxlQW9EQztBQUFLLGFBQVMsRUFBQztBQUFmLGtCQUNDLDJEQUFDLDZEQUFEO0FBQ0MsUUFBSSxFQUFDLFFBRE47QUFFQyxXQUFPLEVBQUU1QixPQUZWO0FBR0MsYUFBUyxFQUFDO0FBSFgsS0FLRUUsT0FBTyxHQUFHLFlBQUgsR0FBa0IsT0FMM0IsQ0FERCxDQXBERCxlQTZEQztBQUFLLGFBQVMsRUFBQztBQUFmLGtCQUNDLGlGQUFXSixHQUFHLENBQUNlLElBQWYsb0JBQ0MsMkRBQUMsb0VBQUQ7QUFBYSxRQUFJLEVBQUVRLEtBQUssQ0FBQyxRQUFEO0FBQXhCLGdCQURELENBREQsQ0E3REQsQ0FERCxDQURELENBREQsQ0FIRCxDQURBLENBREU7QUFrRkgsQ0F4SUQiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvUGFnZXMvQXV0aC9TaWduaW4uanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgUmVhY3QsIHsgdXNlU3RhdGUgfSBmcm9tICdyZWFjdCc7XG5pbXBvcnQgSGVsbWV0IGZyb20gJ3JlYWN0LWhlbG1ldCc7XG5pbXBvcnQgYXhpb3MgZnJvbSAnYXhpb3MnO1xuaW1wb3J0IHsgSW5lcnRpYSB9IGZyb20gJ0BpbmVydGlhanMvaW5lcnRpYSc7XG5pbXBvcnQgeyBJbmVydGlhTGluaywgdXNlUGFnZSB9IGZyb20gJ0BpbmVydGlhanMvaW5lcnRpYS1yZWFjdCc7XG5pbXBvcnQgeyBUb2FzdENvbnRhaW5lciwgdG9hc3QgfSBmcm9tICdyZWFjdC10b2FzdGlmeSc7XG4vLyBpbXBvcnQgJ3JlYWN0LXRvYXN0aWZ5L2Rpc3QvUmVhY3RUb2FzdGlmeS5jc3MnO1xuaW1wb3J0IEF1dGggZnJvbSAnQC9TaGFyZWQvQXV0aCc7XG5pbXBvcnQgTG9hZGluZ0J1dHRvbiBmcm9tICdAL1NoYXJlZC9Mb2FkaW5nQnV0dG9uJztcblxuaW1wb3J0IFRleHRJbnB1dCBmcm9tICdAL1NoYXJlZC9UZXh0SW5wdXQnO1xuXG5leHBvcnQgZGVmYXVsdCAoKSA9PiB7XG5cdGNvbnN0IHsgcHJvcHMgfSA9IHVzZVBhZ2UoKTtcblx0Y29uc3QgeyBlcnJvcnMsIGFwcCB9ID0gcHJvcHM7XG5cdGNvbnN0IFtzZW5kaW5nLCBzZXRTZW5kaW5nXSA9IHVzZVN0YXRlKGZhbHNlKTtcblx0Y29uc3QgW290cEZvcm0sIHNldE90cEZvcm1dID0gdXNlU3RhdGUoZmFsc2UpO1xuXHRjb25zdCBbdmFsdWVzLCBzZXRWYWx1ZXNdID0gdXNlU3RhdGUoe1xuXHRcdHBob25lX251bWJlcjogJycsXG5cdFx0cGFzc3dvcmQ6ICcnLFxuXHRcdG90cDogJycsXG5cdH0pO1xuXHRcblx0ZnVuY3Rpb24gaGFuZGxlQ2hhbmdlKGUpIHtcblx0XHRjb25zdCBrZXkgPSBlLnRhcmdldC5uYW1lO1xuXHRcdGNvbnN0IHZhbHVlID1cblx0XHRlLnRhcmdldC50eXBlID09PSAnY2hlY2tib3gnID8gZS50YXJnZXQuY2hlY2tlZCA6IGUudGFyZ2V0LnZhbHVlO1xuXG5cdFx0c2V0VmFsdWVzKHZhbHVlcyA9PiAoe1xuXHRcdFx0Li4udmFsdWVzLFxuXHRcdFx0W2tleV06IHZhbHVlXG5cdFx0fSkpO1xuXHR9XG5cdFxuXHRmdW5jdGlvbiBoYW5kbGVTdWJtaXQoZSkge1xuXHRcdGUucHJldmVudERlZmF1bHQoKTtcblx0XHRzZXRTZW5kaW5nKHRydWUpO1xuXHRcdFxuXHRcdGF4aW9zLnBvc3Qocm91dGUoJ3NpZ25pbi52ZXJpZnknKSwgdmFsdWVzKS50aGVuKChyZXMpID0+IHtcblx0XHRcdGlmKHJlcy5kYXRhLnR5cGU9PSdzdWNjZXNzJyl7XG5cdFx0XHRcdGlmKHJlcy5kYXRhLm90cCl7XG5cdFx0XHRcdFx0c2V0T3RwRm9ybSh0cnVlKTtcblx0XHRcdFx0XHRzZXRTZW5kaW5nKGZhbHNlKTtcblx0XHRcdFx0fVxuXHRcdFx0XHRlbHNlIHtcblx0XHRcdFx0XHRJbmVydGlhLnBvc3Qocm91dGUoJ3NpZ25pbi5hdHRlbXB0JyksIHZhbHVlcykudGhlbigoKSA9PiB7XG5cdFx0XHRcdFx0XHRzZXRTZW5kaW5nKGZhbHNlKTtcblx0XHRcdFx0XHR9KTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdFx0ZWxzZSB7XG5cdFx0XHRcdHNldFNlbmRpbmcoZmFsc2UpO1xuXHRcdFx0XHR0b2FzdChyZXMuZGF0YS5tZXNzYWdlKTtcblx0XHRcdH1cblx0XHR9KTtcblx0XHRcblx0XHRcblx0fVxuXG5cdC8vLi4uXG5cdGZ1bmN0aW9uIHJlc2VuZE90cCgpIHtcblx0XHRheGlvcy5wb3N0KHJvdXRlKCdyZXNlbmQub3RwJyksIHZhbHVlcykudGhlbigocmVzKSA9PiB7XG5cdFx0XHR0b2FzdChyZXMuZGF0YS5tZXNzYWdlKTtcblx0XHR9KTtcblx0fVxuXHRcbiAgICByZXR1cm4gKFxuXHRcdDxBdXRoPlxuXHRcdDxkaXY+XG5cdFx0XHQ8SGVsbWV0IHRpdGxlPVwiTG9naW5cIiAvPlxuXHRcblx0XHRcdDxtYWluIGNsYXNzTmFtZT1cIm1haW4tY29udGVudFwiPlxuXHRcdFx0XHQ8ZGl2IGNsYXNzTmFtZT1cImF1dGhlbnRpY2F0aW9uLXBhZ2Utd3JhcHBlciBtYXgtNTYyXCI+XG5cdFx0XHRcdFx0PGRpdiBjbGFzc05hbWU9XCJjb250YWluZXJcIj5cblx0XHRcdFx0XHRcdDxmb3JtIG9uU3VibWl0PXtoYW5kbGVTdWJtaXR9IGlkPVwibG9naW4tZm9ybVwiPlx0XHRcdFx0XG5cdFx0XHRcdFx0XHRcdFxuXHRcdFx0XHRcdFx0XHR7IW90cEZvcm0gJiZcblx0XHRcdFx0XHRcdFx0PD5cblx0XHRcdFx0XHRcdFx0PGRpdiBjbGFzc05hbWU9XCJmb3JtLWdyb3VwaCBmb3JtLWhlYWRpbmcgdGV4dC1jZW50ZXJcIj5cblx0XHRcdFx0XHRcdFx0XHQ8aDI+bG9naW48L2gyPlxuXHRcdFx0XHRcdFx0XHQ8L2Rpdj5cblx0XHRcdFx0XHRcdFx0PGRpdiBjbGFzc05hbWU9XCJmb3JtLWdyb3VwaCBpbnB1dC1kZXNpZ25cIj5cblx0XHRcdFx0XHRcdFx0XHQ8VGV4dElucHV0XG5cdFx0XHRcdFx0XHRcdFx0XHRwbGFjZWhvbGRlcj1cIkVtYWlsLyBQaG9uZSBOdW1iZXJcIlxuXHRcdFx0XHRcdFx0XHRcdFx0bmFtZT1cInBob25lX251bWJlclwiXG5cdFx0XHRcdFx0XHRcdFx0XHR0eXBlPVwibnVtYmVyXCJcblx0XHRcdFx0XHRcdFx0XHRcdHZhbHVlPXt2YWx1ZXMucGhvbmVfbnVtYmVyfVxuXHRcdFx0XHRcdFx0XHRcdFx0ZXJyb3JzPXtlcnJvcnMucGhvbmVfbnVtYmVyfVxuXHRcdFx0XHRcdFx0XHRcdFx0b25DaGFuZ2U9e2hhbmRsZUNoYW5nZX1cblx0XHRcdFx0XHRcdFx0XHRcdC8+XG5cdFx0XHRcdFx0XHRcdDwvZGl2PlxuXHRcdFx0XHRcdFx0XHQ8ZGl2IGNsYXNzTmFtZT1cImZvcm0tZ3JvdXBoIGlucHV0LWRlc2lnblwiPlxuXHRcdFx0XHRcdFx0XHRcdDxUZXh0SW5wdXRcblx0XHRcdFx0XHRcdFx0XHRcdHBsYWNlaG9sZGVyPVwiUGFzc3dvcmRcIlxuXHRcdFx0XHRcdFx0XHRcdFx0bmFtZT1cInBhc3N3b3JkXCJcblx0XHRcdFx0XHRcdFx0XHRcdHR5cGU9XCJwYXNzd29yZFwiXG5cdFx0XHRcdFx0XHRcdFx0XHR2YWx1ZT17dmFsdWVzLnBhc3N3b3JkfVxuXHRcdFx0XHRcdFx0XHRcdFx0ZXJyb3JzPXtlcnJvcnMucGFzc3dvcmR9XG5cdFx0XHRcdFx0XHRcdFx0XHRvbkNoYW5nZT17aGFuZGxlQ2hhbmdlfVxuXHRcdFx0XHRcdFx0XHRcdFx0Lz5cblx0XHRcdFx0XHRcdFx0PC9kaXY+XG5cdFx0XHRcdFx0XHRcdDxkaXYgY2xhc3NOYW1lPVwiZm9ybS1ncm91cGggZm9yZ2V0LXBhc3N3b3JkIHRleHQtcmlnaHRcIj5cblx0XHRcdFx0XHRcdFx0XHQ8SW5lcnRpYUxpbmsgaHJlZj17cm91dGUoJ2ZvcmdvdCcpfT5Gb3Jnb3QgUGFzc3dvcmQ/PC9JbmVydGlhTGluaz5cblx0XHRcdFx0XHRcdFx0PC9kaXY+XG5cdFx0XHRcdFx0XHRcdDwvPlxuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFxuXHRcdFx0XHRcdFx0XHR7b3RwRm9ybSAmJlxuXHRcdFx0XHRcdFx0XHQ8PlxuXHRcdFx0XHRcdFx0XHQ8ZGl2IGNsYXNzTmFtZT1cImZvcm0tZ3JvdXBoIGZvcm0taGVhZGluZyB0ZXh0LWNlbnRlclwiPlxuXHRcdFx0XHRcdFx0XHRcdDxoMj5WZXJpZmljYXRpb24gQ29kZTwvaDI+XG5cdFx0XHRcdFx0XHRcdDwvZGl2PlxuXHRcdFx0XHRcdFx0XHQ8ZGl2IGNsYXNzTmFtZT1cImZvcm0tZ3JvdXBoIGlucHV0LWRlc2lnblwiPlxuXHRcdFx0XHRcdFx0XHRcdDxUZXh0SW5wdXRcblx0XHRcdFx0XHRcdFx0XHRcdHBsYWNlaG9sZGVyPVwiQ29kZVwiXG5cdFx0XHRcdFx0XHRcdFx0XHRuYW1lPVwib3RwXCJcblx0XHRcdFx0XHRcdFx0XHRcdHR5cGU9XCJudW1iZXJcIlxuXHRcdFx0XHRcdFx0XHRcdFx0dmFsdWU9e3ZhbHVlcy5vdHB9XG5cdFx0XHRcdFx0XHRcdFx0XHRlcnJvcnM9e2Vycm9ycy5vdHB9XG5cdFx0XHRcdFx0XHRcdFx0XHRvbkNoYW5nZT17aGFuZGxlQ2hhbmdlfVxuXHRcdFx0XHRcdFx0XHRcdFx0Lz5cblx0XHRcdFx0XHRcdFx0PC9kaXY+XG5cdFx0XHRcdFx0XHRcdDxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIiBjbGFzc05hbWU9XCJyZXNlbmRPdHBcIiBvbkNsaWNrPXsoKSA9PiByZXNlbmRPdHAoKX0+UmVzZW5kIENvZGU8L2E+XG5cdFx0XHRcdFx0XHRcdDwvPlxuXHRcdFx0XHRcdFx0XHR9XG5cdFx0XHRcdFx0XHRcdFxuXHRcdFx0XHRcdFx0XHQ8ZGl2IGNsYXNzTmFtZT1cImZvcm0tZ3JvdXBoIHN1Ym1pdC1kZXNpZ24gdGV4dC1jZW50ZXIgbWFyZ2luLWF1dG9cIj5cblx0XHRcdFx0XHRcdFx0XHQ8TG9hZGluZ0J1dHRvblxuXHRcdFx0XHRcdFx0XHRcdFx0dHlwZT1cInN1Ym1pdFwiXG5cdFx0XHRcdFx0XHRcdFx0XHRsb2FkaW5nPXtzZW5kaW5nfVxuXHRcdFx0XHRcdFx0XHRcdFx0Y2xhc3NOYW1lPVwicGluay1idG4tZGVzaWduXCJcblx0XHRcdFx0XHRcdFx0XHRcdD5cblx0XHRcdFx0XHRcdFx0XHRcdHtvdHBGb3JtID8gJ1ZlcmlmeSBPVFAnIDogJ0xvZ2luJyB9XG5cdFx0XHRcdFx0XHRcdFx0PC9Mb2FkaW5nQnV0dG9uPlxuXHRcdFx0XHRcdFx0XHQ8L2Rpdj5cblx0XHRcdFx0XHRcdFx0PGRpdiBjbGFzc05hbWU9XCJmb3JtLWdyb3VwaCBzaWdudXAtdGV4dCB0ZXh0LWNlbnRlclwiPlxuXHRcdFx0XHRcdFx0XHRcdDxwPk5ldyB0byB7YXBwLm5hbWV9PyBcblx0XHRcdFx0XHRcdFx0XHRcdDxJbmVydGlhTGluayBocmVmPXtyb3V0ZSgnc2lnbnVwJyl9PiBTaWduIFVwPC9JbmVydGlhTGluaz5cblx0XHRcdFx0XHRcdFx0XHQ8L3A+XG5cdFx0XHRcdFx0XHRcdDwvZGl2PlxuXHRcdFx0XHRcdFx0PC9mb3JtPlxuXHRcdFx0XHRcdDwvZGl2PlxuXHRcdFx0XHQ8L2Rpdj5cblx0XHRcdDwvbWFpbj5cblx0XHQ8L2Rpdj5cblxuXHQ8L0F1dGg+XG4gICAgKTtcbn07Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/Pages/Auth/Signin.js\n");

/***/ }),

/***/ "./resources/js/Shared/Auth.js":
/*!*************************************!*\
  !*** ./resources/js/Shared/Auth.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return Auth; });\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var react_helmet__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-helmet */ \"./node_modules/react-helmet/es/Helmet.js\");\n/* harmony import */ var _inertiajs_progress__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @inertiajs/progress */ \"./node_modules/@inertiajs/progress/dist/index.js\");\n/* harmony import */ var _inertiajs_progress__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_progress__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @inertiajs/inertia-react */ \"./node_modules/@inertiajs/inertia-react/dist/index.js\");\n/* harmony import */ var _inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var _Shared_AuthHeader__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @/Shared/AuthHeader */ \"./resources/js/Shared/AuthHeader.js\");\n/* harmony import */ var _Shared_Footer__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @/Shared/Footer */ \"./resources/js/Shared/Footer.js\");\n/* harmony import */ var _Shared_FlashMessages__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @/Shared/FlashMessages */ \"./resources/js/Shared/FlashMessages.js\");\n\n\n\n\n\n\n\nfunction Auth(_ref) {\n  var children = _ref.children;\n\n  var _usePage = Object(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_3__[\"usePage\"])(),\n      props = _usePage.props;\n\n  var app = props.app;\n  _inertiajs_progress__WEBPACK_IMPORTED_MODULE_2__[\"InertiaProgress\"].init({\n    color: '#ed60bd',\n    includeCSS: true,\n    showSpinner: true\n  });\n  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react_helmet__WEBPACK_IMPORTED_MODULE_1__[\"default\"], {\n    titleTemplate: \"%s | \".concat(app.name)\n  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_AuthHeader__WEBPACK_IMPORTED_MODULE_4__[\"default\"], null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_FlashMessages__WEBPACK_IMPORTED_MODULE_6__[\"default\"], null), children, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Shared_Footer__WEBPACK_IMPORTED_MODULE_5__[\"default\"], null));\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvU2hhcmVkL0F1dGguanM/YzMzMCJdLCJuYW1lcyI6WyJBdXRoIiwiY2hpbGRyZW4iLCJ1c2VQYWdlIiwicHJvcHMiLCJhcHAiLCJJbmVydGlhUHJvZ3Jlc3MiLCJpbml0IiwiY29sb3IiLCJpbmNsdWRlQ1NTIiwic2hvd1NwaW5uZXIiLCJuYW1lIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUVBO0FBQ0E7QUFDQTtBQUVlLFNBQVNBLElBQVQsT0FBNEI7QUFBQSxNQUFaQyxRQUFZLFFBQVpBLFFBQVk7O0FBQUEsaUJBQ3hCQyx3RUFBTyxFQURpQjtBQUFBLE1BQ2xDQyxLQURrQyxZQUNsQ0EsS0FEa0M7O0FBQUEsTUFFbENDLEdBRmtDLEdBRTFCRCxLQUYwQixDQUVsQ0MsR0FGa0M7QUFJMUNDLHFFQUFlLENBQUNDLElBQWhCLENBQXFCO0FBQ3BCQyxTQUFLLEVBQUUsU0FEYTtBQUVwQkMsY0FBVSxFQUFFLElBRlE7QUFHcEJDLGVBQVcsRUFBRTtBQUhPLEdBQXJCO0FBTUEsc0JBQ0MscUZBQ0MsMkRBQUMsb0RBQUQ7QUFBUSxpQkFBYSxpQkFBVUwsR0FBRyxDQUFDTSxJQUFkO0FBQXJCLElBREQsZUFHQywyREFBQywwREFBRCxPQUhELGVBSUMsMkRBQUMsNkRBQUQsT0FKRCxFQUtFVCxRQUxGLGVBTUMsMkRBQUMsc0RBQUQsT0FORCxDQUREO0FBVUEiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvU2hhcmVkL0F1dGguanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgUmVhY3QsIHsgdXNlU3RhdGUgfSBmcm9tICdyZWFjdCc7XG5pbXBvcnQgSGVsbWV0IGZyb20gJ3JlYWN0LWhlbG1ldCc7XG5pbXBvcnQgeyBJbmVydGlhUHJvZ3Jlc3MgfSBmcm9tICdAaW5lcnRpYWpzL3Byb2dyZXNzJztcbmltcG9ydCB7IHVzZVBhZ2UgfSBmcm9tICdAaW5lcnRpYWpzL2luZXJ0aWEtcmVhY3QnO1xuXG5pbXBvcnQgQXV0aEhlYWRlciBmcm9tICdAL1NoYXJlZC9BdXRoSGVhZGVyJztcbmltcG9ydCBGb290ZXIgZnJvbSAnQC9TaGFyZWQvRm9vdGVyJztcbmltcG9ydCBGbGFzaE1lc3NhZ2VzIGZyb20gJ0AvU2hhcmVkL0ZsYXNoTWVzc2FnZXMnO1xuXG5leHBvcnQgZGVmYXVsdCBmdW5jdGlvbiBBdXRoKHsgY2hpbGRyZW4gfSkge1xuXHRjb25zdCB7IHByb3BzIH0gPSB1c2VQYWdlKCk7XG5cdGNvbnN0IHsgYXBwIH0gPSBwcm9wcztcblx0XG5cdEluZXJ0aWFQcm9ncmVzcy5pbml0KHtcblx0XHRjb2xvcjogJyNlZDYwYmQnLFxuXHRcdGluY2x1ZGVDU1M6IHRydWUsXG5cdFx0c2hvd1NwaW5uZXI6IHRydWUsXG5cdH0pO1xuXHRcblx0cmV0dXJuIChcblx0XHQ8ZGl2PlxuXHRcdFx0PEhlbG1ldCB0aXRsZVRlbXBsYXRlPXtgJXMgfCAke2FwcC5uYW1lfWB9IC8+XG5cdFx0XHRcblx0XHRcdDxBdXRoSGVhZGVyIC8+XG5cdFx0XHQ8Rmxhc2hNZXNzYWdlcyAvPlxuXHRcdFx0e2NoaWxkcmVufVxuXHRcdFx0PEZvb3RlciAvPlxuXHRcdDwvZGl2PlxuXHQpO1xufSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/Shared/Auth.js\n");

/***/ }),

/***/ "./resources/js/Shared/AuthHeader.js":
/*!*******************************************!*\
  !*** ./resources/js/Shared/AuthHeader.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @inertiajs/inertia-react */ \"./node_modules/@inertiajs/inertia-react/dist/index.js\");\n/* harmony import */ var _inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_1__);\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (function () {\n  var _usePage = Object(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_1__[\"usePage\"])(),\n      props = _usePage.props;\n\n  var app = props.app;\n  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"header\", {\n    id: \"main-header\",\n    className: \"relative-header\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"header-logo text-center\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_inertiajs_inertia_react__WEBPACK_IMPORTED_MODULE_1__[\"InertiaLink\"], {\n    href: route('home'),\n    className: \"pink\"\n  }, app.name)));\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvU2hhcmVkL0F1dGhIZWFkZXIuanM/N2I2YiJdLCJuYW1lcyI6WyJ1c2VQYWdlIiwicHJvcHMiLCJhcHAiLCJyb3V0ZSIsIm5hbWUiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUFBO0FBQUE7QUFBQTtBQUNBO0FBRWUsMkVBQU07QUFBQSxpQkFDRkEsd0VBQU8sRUFETDtBQUFBLE1BQ1pDLEtBRFksWUFDWkEsS0FEWTs7QUFBQSxNQUVaQyxHQUZZLEdBRUpELEtBRkksQ0FFWkMsR0FGWTtBQUlwQixzQkFDQztBQUFRLE1BQUUsRUFBQyxhQUFYO0FBQXlCLGFBQVMsRUFBQztBQUFuQyxrQkFDQztBQUFLLGFBQVMsRUFBQztBQUFmLGtCQUNDLDJEQUFDLG9FQUFEO0FBQWEsUUFBSSxFQUFFQyxLQUFLLENBQUMsTUFBRCxDQUF4QjtBQUFrQyxhQUFTLEVBQUM7QUFBNUMsS0FDRUQsR0FBRyxDQUFDRSxJQUROLENBREQsQ0FERCxDQUREO0FBU0EsQ0FiRCIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9TaGFyZWQvQXV0aEhlYWRlci5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCBSZWFjdCwgeyB1c2VTdGF0ZSB9IGZyb20gJ3JlYWN0JztcbmltcG9ydCB7IEluZXJ0aWFMaW5rLCB1c2VQYWdlIH0gZnJvbSAnQGluZXJ0aWFqcy9pbmVydGlhLXJlYWN0JztcblxuZXhwb3J0IGRlZmF1bHQgKCkgPT4ge1xuXHRjb25zdCB7IHByb3BzIH0gPSB1c2VQYWdlKCk7XG5cdGNvbnN0IHsgYXBwIH0gPSBwcm9wcztcblx0XG5cdHJldHVybiAoXG5cdFx0PGhlYWRlciBpZD1cIm1haW4taGVhZGVyXCIgY2xhc3NOYW1lPVwicmVsYXRpdmUtaGVhZGVyXCI+XG5cdFx0XHQ8ZGl2IGNsYXNzTmFtZT1cImhlYWRlci1sb2dvIHRleHQtY2VudGVyXCI+XG5cdFx0XHRcdDxJbmVydGlhTGluayBocmVmPXtyb3V0ZSgnaG9tZScpfSBjbGFzc05hbWU9XCJwaW5rXCI+XG5cdFx0XHRcdFx0e2FwcC5uYW1lfVxuXHRcdFx0XHQ8L0luZXJ0aWFMaW5rPlxuXHRcdFx0PC9kaXY+XG5cdFx0PC9oZWFkZXI+XG5cdCk7XG59O1xuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/Shared/AuthHeader.js\n");

/***/ })

}]);