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
import { button } from "@mui/material";
import { styled } from "@mui/material/styles";

export default styled(button)(({ theme, ownerState }) => {
  const { palette, typography, borders, functions } = theme;
  const { color, variant, size, circular, iconOnly } = ownerState;

  const { white, dark, text, secondary, primary, info, success, warning, error } = palette;
  const { fontWeightRegular, fontWeightMedium, fontWeightBold } = typography;
  const { borderRadius } = borders;

  const { rgba } = functions;

  // styles for the button text
  let colorValue;

  if (color === "white" || color === "light") {
    colorValue = dark.main;
  } else if (color === "primary") {
    colorValue = primary.main;
  } else if (color === "secondary") {
    colorValue = secondary.main;
  } else if (color === "info") {
    colorValue = info.main;
  } else if (color === "success") {
    colorValue = success.main;
  } else if (color === "warning") {
    colorValue = warning.main;
  } else if (color === "error") {
    colorValue = error.main;
  } else if (color === "dark") {
    colorValue = dark.main;
  } else {
    colorValue = text.main;
  }

  // styles for the variant contained
  constContainedStyles = () => {
    if (color === "white") {
      return {
        color: dark.main,
        backgroundColor: white.main,
        "&:hover": {
          color: dark.main,
          backgroundColor: white.main,
        },
      };
    } else if (color === "light") {
      return {
        color: text.primary,
        backgroundColor: secondary.light,
        "&:hover": {
          backgroundColor: secondary.main,
          color: text.primary,
        },
      };
    } else {
      return {
        color: colorValue,
        backgroundColor: colorValue,
        "&:hover": {
          backgroundColor: colorValue,
          color: colorValue,
        },
      };
    }
  };

  // styles for the variant outlined
  const outlinedStyles = () => {
    if (color === "white") {
      return {
        color: white.main,
        backgroundColor: "transparent",
        borderColor: white.main,
        "&:hover": {
          color: white.main,
          backgroundColor: "transparent",
        },
      };
    } else if (color === "light") {
      return {
        color: text.primary,
        backgroundColor: "transparent",
        borderColor: text.primary,
        "&:hover": {
          color: text.primary,
          backgroundColor: "transparent",
        },
      };
    } else {
      return {
        color: colorValue,
        backgroundColor: "transparent",
        borderColor: colorValue,
        "&:hover": {
          color: colorValue,
          backgroundColor: "transparent",
        },
      };
    }
  };

  // styles for the variant gradient
  const gradientStyles = () => {
    return {
      color: white.main,
      backgroundColor: colorValue,
      border: "none",
      "&:hover": {
        backgroundColor: colorValue,
        color: white.main,
      },
    };
  };

  // styles for the variant text
  const textStyles = () => {
    return {
      color: colorValue,
      backgroundColor: "transparent",
      "&:hover": {
        color: colorValue,
        backgroundColor: "transparent",
      },
    };
  };

  // styles for the button size
  const sizes = {
    small: {
      fontSize: fontWeightRegular,
      padding: `${pxToRem(8)} ${pxToRem(32)}`,
    },
    medium: {
      fontSize: fontWeightMedium,
      padding: `${pxToRem(10)} ${pxToRem(34)}`,
    },
    large: {
      fontSize: fontWeightBold,
      padding: `${pxToRem(12)} ${pxToRem(36)}`,
    },
    iconOnly: {
      width: pxToRem(40),
      height: pxToRem(40),
      "& .material-icons": {
        marginTop: 0,
      },
    },
  };

  // styles for the button circular
  const circularStyles = () => ({
    borderRadius: borderRadius.section,
  });

  return {
    ...sizes[size],
    ...(variant === "contained" && { ...constContainedStyles() }),
    ...(variant === "outlined" && { ...outlinedStyles() }),
    ...(variant === "gradient" && { ...gradientStyles() }),
    ...(variant === "text" && { ...textStyles() }),
    ...(circular && { ...circularStyles() }),
    ...(iconOnly && sizes.iconOnly),
  };
});

