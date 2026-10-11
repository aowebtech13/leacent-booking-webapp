"use client";

import React, { useState } from "react";
import Link from "next/link";
import { useRouter } from "next/navigation";
import { register as apiRegister, verifyOtp } from "@/lib/api";

const EMAIL_PATTERN = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;

type FormData = {
  fullName: string;
  email: string;
  password: string;
  confirmPassword: string;
  terms: boolean;
};
type FormErrors = Partial<Record<keyof FormData, string>>;

const SignUpPage = () => {
  const [isLoading, setIsLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [emailSent, setEmailSent] = useState<string | null>(null);
  const [formData, setFormData] = useState<FormData>({
    fullName: "",
    email: "",
    password: "",
    confirmPassword: "",
    terms: false,
  });
  const [formErrors, setFormErrors] = useState<FormErrors>({});
  const router = useRouter();

  const validate = (): FormErrors => {
    const errors: FormErrors = {};
    if (!formData.fullName.trim()) {
      errors.fullName = "Full name is required";
    } else if (formData.fullName.trim().length < 2) {
      errors.fullName = "Name must be at least 2 characters";
    }
    if (!formData.email.trim()) {
      errors.email = "Email is required";
    } else if (!EMAIL_PATTERN.test(formData.email)) {
      errors.email = "Invalid email address";
    }
    if (!formData.password) {
      errors.password = "Password is required";
    } else if (formData.password.length < 8) {
      errors.password = "Password must be at least 8 characters";
    }
    if (!formData.confirmPassword) {
      errors.confirmPassword = "Please confirm your password";
    } else if (formData.confirmPassword !== formData.password) {
      errors.confirmPassword = "Passwords do not match";
    }
    if (!formData.terms) {
      errors.terms = "You must accept the terms and conditions";
    }
    return errors;
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, type, checked } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value,
    }));
    if (formErrors[name as keyof FormData]) {
      setFormErrors((prev) => ({ ...prev, [name]: "" }));
    }
  };

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const errors = validate();
    setFormErrors(errors);
    if (Object.keys(errors).length > 0) return;

    setIsLoading(true);
    setError(null);

    try {
      const res = await apiRegister({
        name: formData.fullName,
        email: formData.email,
        password: formData.password,
        password_confirmation: formData.confirmPassword,
      });
      // Backend returns the email the code was sent to.
      setEmailSent(res?.email || formData.email);
      // Pre-fill the verify-otp page with the email via query param.
      router.push(`/verify-otp?email=${encodeURIComponent(formData.email)}`);
    } catch (err: any) {
      setError(err?.message || "Failed to create account. Please try again.");
      setIsLoading(false);
    }
  };

  return (
    <div className="auth-page-wrapper">
      <div className="auth-box">
        <div className="auth-header text-center mb-4">
          <h2 className="f-w-700 text-primary-dark">Create Account</h2>
          <p className="text-muted mt-2">Join Axelit today</p>
        </div>

        <form onSubmit={onSubmit} className="auth-form" noValidate>
          {error && (
            <div className="alert alert-danger alert-dismissible fade show" role="alert">
              {error}
              <button type="button" className="btn-close" onClick={() => setError(null)}></button>
            </div>
          )}

          <div className="mb-3">
            <label htmlFor="fullName" className="form-label f-w-500">
              Full Name
            </label>
            <input
              type="text"
              className={`form-control ${formErrors.fullName ? "is-invalid" : ""}`}
              id="fullName"
              name="fullName"
              placeholder="Enter your full name"
              value={formData.fullName}
              onChange={handleChange}
            />
            {formErrors.fullName && (
              <div className="invalid-feedback">{formErrors.fullName}</div>
            )}
          </div>

          <div className="mb-3">
            <label htmlFor="email" className="form-label f-w-500">
              Email Address
            </label>
            <input
              type="email"
              className={`form-control ${formErrors.email ? "is-invalid" : ""}`}
              id="email"
              name="email"
              placeholder="Enter your email"
              value={formData.email}
              onChange={handleChange}
            />
            {formErrors.email && (
              <div className="invalid-feedback">{formErrors.email}</div>
            )}
          </div>

          <div className="mb-3">
            <label htmlFor="password" className="form-label f-w-500">
              Password
            </label>
            <input
              type="password"
              className={`form-control ${formErrors.password ? "is-invalid" : ""}`}
              id="password"
              name="password"
              placeholder="Create a password"
              value={formData.password}
              onChange={handleChange}
            />
            {formErrors.password && (
              <div className="invalid-feedback">{formErrors.password}</div>
            )}
          </div>

          <div className="mb-3">
            <label htmlFor="confirmPassword" className="form-label f-w-500">
              Confirm Password
            </label>
            <input
              type="password"
              className={`form-control ${formErrors.confirmPassword ? "is-invalid" : ""}`}
              id="confirmPassword"
              name="confirmPassword"
              placeholder="Confirm your password"
              value={formData.confirmPassword}
              onChange={handleChange}
            />
            {formErrors.confirmPassword && (
              <div className="invalid-feedback">{formErrors.confirmPassword}</div>
            )}
          </div>

          <div className="mb-4">
            <div className="form-check">
              <input
                type="checkbox"
                className={`form-check-input ${formErrors.terms ? "is-invalid" : ""}`}
                id="terms"
                name="terms"
                checked={formData.terms}
                onChange={handleChange}
              />
              <label className="form-check-label text-muted" htmlFor="terms">
                I agree to the{" "}
                <Link href="/other-pages/terms-condition" className="text-primary">
                  Terms & Conditions
                </Link>{" "}
                and{" "}
                <Link href="/other-pages/privacy-policy" className="text-primary">
                  Privacy Policy
                </Link>
              </label>
            </div>
            {formErrors.terms && (
              <div className="invalid-feedback d-block">{formErrors.terms}</div>
            )}
          </div>

          <button
            type="submit"
            className="btn btn-primary w-100 py-2 f-w-600"
            disabled={isLoading}
          >
            {isLoading ? (
              <span className="d-flex align-items-center justify-content-center gap-2">
                <span className="spinner-border spinner-border-sm" role="status"></span>
                Creating Account...
              </span>
            ) : (
              "Sign Up"
            )}
          </button>
        </form>

        <div className="text-center mt-4">
          <p className="text-muted mb-0">
            Already have an account?{" "}
            <Link href="/sign-in" className="text-primary f-w-600">
              Sign In
            </Link>
          </p>
        </div>

        <div className="divider my-4">
          <span>Or sign up with</span>
        </div>

        <div className="d-grid gap-2">
          <button type="button" className="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
            <img src="/images/setting-app/google.png" alt="Google" className="auth-social-icon" />
            Continue with Google
          </button>
          <button type="button" className="btn btn-outline-secondary d-flex align-items-center justify-content-center gap-2">
            <img src="/images/setting-app/facebook.png" alt="Facebook" className="auth-social-icon" />
            Continue with Facebook
          </button>
        </div>
      </div>
    </div>
  );
};

export default SignUpPage;