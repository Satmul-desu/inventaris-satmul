/**
=========================================================
* Argon Dashboard 2 MUI - v3.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-material-ui
* Copyright 2023 Creative Tim (https://www.creative-tim.com)

Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
*/

const { boxShadows } = boxShadows;
const { borders } = borders;

const globals = (pxToRem, boxShadows, linearGradient) => ({
  html: {
    scrollBehavior: "smooth",
  },
  "*, *::before, *::after": {
    margin: 0,
    padding: 0,
  },
  "html, body": {
    width: "100%",
    height: "100%",
  },
  "#root": {
    width: "100%",
    height: "100%",
  },
  a: {
    color: "#172b4d",
    textDecoration: "none !important",
    "&:hover": {
      color: "#5e72e4",
    },
  },
  ".bg-default": {
    backgroundColor: "#f8f9fa !important",
  },
  ".bg-soft": {
    backgroundColor: "#fff !important",
    boxShadow: boxShadows["0 4px 10px 0 rgba(0,0,0,0.05)!important",
  },
  body: {
    backgroundColor: "#f8f9fa",
    margin: 0,
    fontFamily: '"Roboto", "Helvetica", "Arial", sans-serif',
  },
  section: {
    position: "relative",
    overflow: "hidden",
  },
  ".main-content": {
    padding: `${pxToRem(8)} !important`,
  },
  ".page-header": {
    position: "relative",
    padding: `${pxToRem(160)} 0 ${pxToRem(160)}`,
    borderRadius: "none",
    background: linearGradient,
    backgroundPosition: "50%",
  },
  ".page-header-img": {
    position: "absolute",
    top: 0,
    left: 0,
    width: "100%",
    height: "100%",
    objectFit: "cover",
    objectPosition: "center",
  },
  "input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus": {
    border: `1px solid ${borders.borderColor}`,
    borderRadius: `${borders.radius} !important`,
    boxShadow: `0 0 0 100px #fff inset !important`,
    "-webkit-box-shadow": `0 0 0 100px #fff inset !important`,
    "-webkit-text-fill-color": "#172b4d !important",
  },
  "input:-webkit-autofill::first-line": {
    fontFamily: '"Roboto", "Helvetica", "Arial", sans-serif !important',
    fontSize: `${pxToRem(16)} !important`,
  },
  ".ReactCodeMirror": {
    ".CodeMirror": {
      height: "100vh !important",
      borderRadius: `${borders.radiusLg}`,
    },
  },
  ".ReactTable .-pagination": {
    borderTop: "none !important",
  },
  ".ReactTable .-pagination .-previous, .-pagination .-next": {
    backgroundColor: "transparent !important",
  },
  ".ReactTable .-pagination input": {
    backgroundColor: "transparent !important",
  },
  ".ScrollspyNav": {
    "&.navbar": {
      zIndex: 99,
    },
    "& .nav-link": {
      padding: `${pxToRem(5)} ${pxToRem(5)} !important`,
    },
  },
  ".Search": {
    "&.modal": {
      maxWidth: "300px",
      width: "100%",
    },
  },
  ".ReactTable.CRUD": {
    ".rt-thead.-filters": {
      borderBottom: "none !important",
      ".rt-th": {
        borderBottom: "none !important",
      },
    },
    ".rt-tbody": {
      ".rt-tr": {
        borderBottom: "none !important",
      },
    },
  },
  ".ReactTable.S-table": {
    borderRadius: `${borders.radius} !important`,
    border: "none !important",
    ".rt-thead": {
      backgroundColor: "#f8f9fa",
      borderRadius: `${borders.radius} !important`,
      border: "none !important",
      borderBottom: "none !important",
    },
    ".rt-tbody": {
      border: "none !important",
    },
  },
  ".fc-toolbar": {
    flexWrap: "wrap",
    justifyContent: "center",
    "@media (min-width: 576px)": {
      flexWrap: "nowrap !important",
    },
  },
  ".fc": {
    "@media (max-width: 576px)": {
      ".fc-toolbar": {
        flexDirection: "column",
        ".fc-button-group": {
          marginBottom: "0.5rem !important",
        },
      },
    },
  },
  ".ReactModalPortal": {
    zIndex: 9999,
  },
  ".MuiModal-root": {
    zIndex: 9999,
  },
  ".MuiPickersModal-dialog": {
    zIndex: 9999,
  },
});

export default globals;

