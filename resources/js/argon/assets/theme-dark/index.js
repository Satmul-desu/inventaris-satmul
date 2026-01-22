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

import { styled } from "@mui/material/styles";
import rtlPlugin from "stylis-plugin-rtl";
import { prefixer } from "stylis";
import createCache from "@emotion/cache";

const cache = createCache({
  key: "rtl",
  stylisPlugins: [prefixer, rtlPlugin],
});

const cacheRtl = createCache({
  key: "rtl",
  stylisPlugins: [prefixer, rtlPlugin],
});

// Multi theme object
export const themes = {
  default: {
    palette: {
      mode: "light",
      background: {
        default: "#f8f9fa",
        paper: "#ffffff",
      },
      text: {
        main: "#172b4d",
        fixed: "#ffffff",
      },
    },
  },
};

// Theme with RTL
const themeRTL = {
  ...themes.default,
};

export default themeRTL;

