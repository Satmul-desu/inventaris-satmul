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

import { forwardRef } from "react";

// prop-types is a library for typechecking of props
import PropTypes from "prop-types";

// Custom styles for ArgonButton
import ArgonButtonRoot from "components/ArgonButton/ArgonButtonRoot";

const ArgonButton = forwardRef(
  ({ color, variant, size, circular, iconOnly, children, ...rest }, ref) => (
    <ArgonButtonRoot
      {...rest}
      ref={ref}
      color={color}
      variant={variant === "gradient" ? "contained" : variant}
      size={size}
      ownerState={{ color, variant, size, circular, iconOnly }}
    >
      {children}
    </ArgonButtonRoot>
  )
);

// Setting default values for the props of ArgonButton
ArgonButton.defaultProps = {
  color: "primary",
  variant: "gradient",
  size: "medium",
  circular: false,
  iconOnly: false,
};

// Typechecking props for the ArgonButton
ArgonButton.propTypes = {
  color: PropTypes.oneOf([
    "white",
    "primary",
    "secondary",
    "info",
    "success",
    "warning",
    "error",
    "dark",
  ]),
  variant: PropTypes.oneOf(["text", "outline", "gradient", "contained"]),
  size: PropTypes.oneOf(["small", "medium", "large"]),
  circular: PropTypes.bool,
  iconOnly: PropTypes.bool,
  children: PropTypes.node.isRequired,
};

export default ArgonButton;

