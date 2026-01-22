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
import Typography from "@mui/material/Typography";
import { styled } from "@mui/material/styles";

export default styled(Typography)(({ theme, ownerState }) => {
  const { palette, typography, functions } = theme;
  const { color, fontWeight, textTransform, verticalAlign, textGradient, opacity } = ownerState;

  const { gradients, grey, white } = palette;
  const { fontWeightLight, fontWeightRegular, fontWeightMedium, fontWeightBold } = typography;
  const { linearGradient } = functions;

  // fontWeight values
  const fontWeightValues = {
    light: fontWeightLight,
    regular: fontWeightRegular,
    medium: fontWeightMedium,
    bold: fontWeightBold,
  };

  // color values
  const colorValues = {
    transparent: "transparent",
    white: white.main,
    text: grey[600],
    grey: grey[500],
    primary: gradients.primary.main,
    secondary: gradients.secondary.main,
    info: gradients.info.main,
    success: gradients.success.main,
    warning: gradients.warning.main,
    error: gradients.error.main,
    dark: gradients.dark.main,
  };

  // styles for the textGradient
  const styles = {
    color: colorValues[color] || color,
    opacity,
    textTransform,
    verticalAlign,
    fontWeight: fontWeightValues[fontWeight] || false,
  };

  // styles for the textGradient
  if (textGradient) {
    styles.backgroundImage = linearGradient(colorValues[color] || color, colorValues[color] || color);
    styles.WebkitBackgroundClip = "text";
    styles.WebkitTextFillColor = "transparent";
  }

  return styles;
});

