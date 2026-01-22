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

// @mui material components
import { createTheme } from "@mui/material/styles";
import { styled } from "@mui/material/styles";
import rtlPlugin from "stylis-plugin-rtl";
import { prefixer } from "stylis";
import createCache from "@emotion/cache";

// ** Layout
// styles for the layout
import {
  boxShadow,
  rgbToHex,
  linearGradient,
  pxToRem,
} from "assets/theme/functions";

// ** Global Styles
import colors from "assets/theme/base/colors";
import globals from "assets/theme/base/globals";
import breakpoints from "assets/theme/base/breakpoints";
import typography from "assets/theme/base/typography";
import boxShadows from "assets/theme/base/boxShadows";
import borders from "assets/theme/base/borders";

// ** Theme Functions
import ArgonBox from "components/ArgonBox";
import ArgonButton from "components/ArgonButton";

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
  default: createTheme({
    palette: {
      mode: "light",
      ...colors,
      background: {
        default: "#f8f9fa",
        paper: "#ffffff",
      },
      text: {
        main: "#172b4d",
        fixed: "#ffffff",
      },
    },
    typography,
    components: {
      MuiAppBar: {
        defaultProps: {
          color: "transparent",
        },
        styleOverrides: {
          root: {
            backgroundImage: "none",
          },
        },
      },
      MuiButton: {
        styleOverrides: {
          root: {
            boxShadow: boxShadows["button"],
            "&:hover": {
              boxShadow: boxShadows["buttonHover"],
            },
          },
        },
      },
      MuiCard: {
        styleOverrides: {
          root: {
            borderRadius: pxToRem(12),
            boxShadow: boxShadows["card"],
          },
        },
      },
      MuiInputBase: {
        styleOverrides: {
          input: {
            "&::placeholder": {
              color: colors.grey[700],
            },
          },
        },
      },
      MuiOutlinedInput: {
        styleOverrides: {
          notchedOutline: {
            borderColor: colors.grey[300],
          },
        },
      },
      MuiButton: {
        styleOverrides: {
          root: {
            boxShadow: "none",
            "&:hover": {
              boxShadow: "none",
            },
          },
        },
      },
    },
  },
  {
    components: {
      MuiCssBaseline: {
        styleOverrides: {
          body: {
            ...globals(pxToRem, boxShadow, linearGradient).body,
          },
        },
      },
      MuiDrawer: {
        styleOverrides: {
          paper: {
            ...globals(pxToRem, boxShadow, linearGradient).paper,
          },
        },
      },
      MuiListItemIcon: {
        styleOverrides: {
          root: {
            color: "#ffffff",
          },
        },
      },
      MuiToolbar: {
        styleOverrides: {
          root: {
            ...globals(pxToRem, boxShadow, linearGradient).toolbar,
          },
        },
      },
    },
  }),
};

// Theme with RTL
const themeRTL = createTheme({
  ...themes.default,
});

themeRTL.components = {
  MuiCssBaseline: {
    styleOverrides: {
      body: {
        ...globals(pxToRem, boxShadow, linearGradient).body,
        textAlign: "right",
      },
    },
  },
  MuiDrawer: {
    styleOverrides: {
      paper: {
        ...globals(pxToRem, boxShadow, linearGradient).paper,
        "& &, & &, &:hover, & .MuiDrawer-paper": {
          border: "none",
        },
      },
    },
  },
  MuiListItemIcon: {
    styleOverrides: {
      root: {
        justifyContent: "flex-end",
      },
    },
  },
  MuiToolbar: {
    styleOverrides: {
      root: {
        ...globals(pxToRem, boxShadow, linearGradient).toolbar,
        "& .MuiBox-root": {
          ...globals(pxToRem, boxShadow, linearGradient).MuiBox,
        },
      },
    },
  },
  MuiButton: {
    styleOverrides: {
      root: {
        borderRadius: pxToRem(4),
        boxShadow: "none",
        "&:hover": {
          boxShadow: "none",
        },
      },
      endIcon: {
        marginLeft: pxToRem(4),
      },
    },
  },
  MuiIconButton: {
    styleOverrides: {
      root: {
        boxShadow: "none",
        "&:hover": {
          boxShadow: "none",
        },
      },
    },
  },
  MuiTextField: {
    styleOverrides: {
      root: {
        "& .MuiOutlinedInput-root": {
          "& fieldset": {
            borderRadius: pxToRem(8),
          },
        },
      },
    },
  },
};

export default themeRTL;

