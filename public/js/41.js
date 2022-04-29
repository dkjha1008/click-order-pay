(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[41],{

/***/ "./resources/js/Pages/Error.js":
/*!*************************************!*\
  !*** ./resources/js/Pages/Error.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ \"./node_modules/react/index.js\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var react_helmet__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-helmet */ \"./node_modules/react-helmet/es/Helmet.js\");\n\n // import { usePage } from '@inertiajs/inertia-react';\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (function (_ref) {\n  var status = _ref.status;\n  // const { status } = usePage();\n  var title = {\n    503: '503: Service Unavailable',\n    500: '500: Server Error',\n    404: '404: Page Not Found',\n    403: '403: Forbidden'\n  }[status];\n  var description = {\n    503: 'Sorry, we are doing some maintenance. Please check back soon.',\n    500: 'Whoops, something went wrong on our servers.',\n    404: 'Sorry, the page you are looking for could not be found.',\n    403: 'Sorry, you are forbidden from accessing this page.'\n  }[status];\n  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"p-5 bg-indigo-800 text-indigo-100 min-h-screen flex justify-center items-center\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react_helmet__WEBPACK_IMPORTED_MODULE_1__[\"default\"], {\n    title: title\n  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"div\", {\n    className: \"w-full max-w-md\"\n  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"h1\", {\n    className: \"text-3xl\"\n  }, title), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(\"p\", {\n    className: \"mt-3 text-lg leading-tight\"\n  }, description)));\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvUGFnZXMvRXJyb3IuanM/MDNkMiJdLCJuYW1lcyI6WyJzdGF0dXMiLCJ0aXRsZSIsImRlc2NyaXB0aW9uIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFBQTtBQUFBO0NBRUE7O0FBRWUsK0VBQWdCO0FBQUEsTUFBYkEsTUFBYSxRQUFiQSxNQUFhO0FBQzdCO0FBRUEsTUFBTUMsS0FBSyxHQUFHO0FBQ1osU0FBSywwQkFETztBQUVaLFNBQUssbUJBRk87QUFHWixTQUFLLHFCQUhPO0FBSVosU0FBSztBQUpPLElBS1pELE1BTFksQ0FBZDtBQU9BLE1BQU1FLFdBQVcsR0FBRztBQUNsQixTQUFLLCtEQURhO0FBRWxCLFNBQUssOENBRmE7QUFHbEIsU0FBSyx5REFIYTtBQUlsQixTQUFLO0FBSmEsSUFLbEJGLE1BTGtCLENBQXBCO0FBT0Esc0JBQ0U7QUFBSyxhQUFTLEVBQUM7QUFBZixrQkFDRSwyREFBQyxvREFBRDtBQUFRLFNBQUssRUFBRUM7QUFBZixJQURGLGVBRUU7QUFBSyxhQUFTLEVBQUM7QUFBZixrQkFDRTtBQUFJLGFBQVMsRUFBQztBQUFkLEtBQTBCQSxLQUExQixDQURGLGVBRUU7QUFBRyxhQUFTLEVBQUM7QUFBYixLQUEyQ0MsV0FBM0MsQ0FGRixDQUZGLENBREY7QUFTRCxDQTFCRCIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9QYWdlcy9FcnJvci5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCBSZWFjdCBmcm9tICdyZWFjdCc7XG5pbXBvcnQgSGVsbWV0IGZyb20gJ3JlYWN0LWhlbG1ldCc7XG4vLyBpbXBvcnQgeyB1c2VQYWdlIH0gZnJvbSAnQGluZXJ0aWFqcy9pbmVydGlhLXJlYWN0JztcblxuZXhwb3J0IGRlZmF1bHQgKHsgc3RhdHVzIH0pID0+IHtcbiAgLy8gY29uc3QgeyBzdGF0dXMgfSA9IHVzZVBhZ2UoKTtcblxuICBjb25zdCB0aXRsZSA9IHtcbiAgICA1MDM6ICc1MDM6IFNlcnZpY2UgVW5hdmFpbGFibGUnLFxuICAgIDUwMDogJzUwMDogU2VydmVyIEVycm9yJyxcbiAgICA0MDQ6ICc0MDQ6IFBhZ2UgTm90IEZvdW5kJyxcbiAgICA0MDM6ICc0MDM6IEZvcmJpZGRlbidcbiAgfVtzdGF0dXNdO1xuXG4gIGNvbnN0IGRlc2NyaXB0aW9uID0ge1xuICAgIDUwMzogJ1NvcnJ5LCB3ZSBhcmUgZG9pbmcgc29tZSBtYWludGVuYW5jZS4gUGxlYXNlIGNoZWNrIGJhY2sgc29vbi4nLFxuICAgIDUwMDogJ1dob29wcywgc29tZXRoaW5nIHdlbnQgd3Jvbmcgb24gb3VyIHNlcnZlcnMuJyxcbiAgICA0MDQ6ICdTb3JyeSwgdGhlIHBhZ2UgeW91IGFyZSBsb29raW5nIGZvciBjb3VsZCBub3QgYmUgZm91bmQuJyxcbiAgICA0MDM6ICdTb3JyeSwgeW91IGFyZSBmb3JiaWRkZW4gZnJvbSBhY2Nlc3NpbmcgdGhpcyBwYWdlLidcbiAgfVtzdGF0dXNdO1xuXG4gIHJldHVybiAoXG4gICAgPGRpdiBjbGFzc05hbWU9XCJwLTUgYmctaW5kaWdvLTgwMCB0ZXh0LWluZGlnby0xMDAgbWluLWgtc2NyZWVuIGZsZXgganVzdGlmeS1jZW50ZXIgaXRlbXMtY2VudGVyXCI+XG4gICAgICA8SGVsbWV0IHRpdGxlPXt0aXRsZX0gLz5cbiAgICAgIDxkaXYgY2xhc3NOYW1lPVwidy1mdWxsIG1heC13LW1kXCI+XG4gICAgICAgIDxoMSBjbGFzc05hbWU9XCJ0ZXh0LTN4bFwiPnt0aXRsZX08L2gxPlxuICAgICAgICA8cCBjbGFzc05hbWU9XCJtdC0zIHRleHQtbGcgbGVhZGluZy10aWdodFwiPntkZXNjcmlwdGlvbn08L3A+XG4gICAgICA8L2Rpdj5cbiAgICA8L2Rpdj5cbiAgKTtcbn07XG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/Pages/Error.js\n");

/***/ })

}]);