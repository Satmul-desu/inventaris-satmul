import { createTheme } from "@mui/material/styles";
import colors from "assets/theme/base/colors";
import typography from "assets/theme/base/typography";
import breakpoints from "assets/theme/base/breakpoints";
import boxShadows from "assets/theme/base/boxShadows";
import borders from "assets/theme/base/borders";
import pxToRem from "assets/theme/functions/pxToRem";
import linearGradient from "assets/theme/functions/linearGradient";
import boxShadow from "assets/theme/functions/boxShadow";
import rgba from "assets/theme/functions/rgba";

const { info, secondary, success, warning, error, dark, grey } = colors;

const theme = createTheme({
  palette: {
    mode: "light",
    primary: {
      main: info.main,
      light: info.light,
      dark: info.dark,
      contrastText: "#ffffff",
    },
    secondary: {
      main: secondary.main,
      light: secondary.light,
      dark: secondary.dark,
      contrastText: "#ffffff",
    },
    success: {
      main: success.main,
      light: success.light,
      dark: success.dark,
      contrastText: "#ffffff",
    },
    warning: {
      main: warning.main,
      light: warning.light,
      dark: warning.dark,
      contrastText: "#ffffff",
    },
    error: {
      main: error.main,
      light: error.light,
      dark: error.dark,
      contrastText: "#ffffff",
    },
    dark: {
      main: dark.main,
      light: dark.light,
      dark: dark.dark,
      contrastText: "#ffffff",
    },
    grey: {
      100: grey[100],
      200: grey[200],
      300: grey[300],
      400: grey[400],
      500: grey[500],
      600: grey[600],
      700: grey[700],
      800: grey[800],
      900: grey[900],
    },
    text: {
      main: "#172b4d",
      secondary: "#6c757d",
    },
    background: {
      default: "#f8f9fa",
      paper: "#ffffff",
    },
  },
  typography,
  breakpoints,
  boxShadows,
  borders: {
    borderColor: borders.borderColor,
    borderRadius: borders.borderRadius,
  },
  functions: {
    linearGradient,
    boxShadow,
    pxToRem,
    rgba,
  },
});

theme.components = {
  MuiAppBar: {
      defaultProps: {
        color: "transparent",
      },
      styleOverrides: {
        root: {
          boxShadow: "none",
        },
      },
    },
    MuiButton: {
      styleOverrides: {
        root: {
          boxShadow: "none",
          borderRadius: pxToRem(4),
          "&:hover": {
            boxShadow: "none",
          },
        },
        contained: {
          padding: `${pxToRem(10)} ${pxToRem(24)}`,
        },
        outlined: {
          padding: `${pxToRem(10)} ${pxToRem(24)}`,
        },
      },
    },
    MuiCard: {
      styleOverrides: {
        root: {
          borderRadius: pxToRem(12),
          boxShadow: "0 4px 10px 0 rgba(0,0,0,0.05) !important",
        },
      },
    },
    MuiInputBase: {
      styleOverrides: {
        input: {
          "&::placeholder": {
            color: "#6c757d",
          },
        },
      },
    },
    MuiOutlinedInput: {
      styleOverrides: {
        notchedOutline: {
          borderColor: "#e9ecef",
        },
      },
    },
    MuiTableHead: {
      styleOverrides: {
        root: {
          backgroundColor: "#f8f9fa",
          borderRadius: pxToRem(8),
          "& .MuiTableCell-root": {
            color: "#6c757d",
          },
          "& .MuiTableCell-head": {
            fontWeight: "700",
          },
        },
      },
    },
};

export default theme;

