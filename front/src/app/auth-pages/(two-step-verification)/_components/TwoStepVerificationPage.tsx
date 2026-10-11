"use client";
import React, { useRef, useState, useEffect } from "react";
import {
  Button,
  Col,
  Container,
  Form,
  FormGroup,
  Input,
  Row,
  Spinner,
  Alert,
} from "reactstrap";
import { useSearchParams } from "next/navigation";
import { verifyOtp, resendOtpAction, ActionError } from "@/lib/auth/action";

const OTP_LENGTH = 4;

const VerifyOtpPage: React.FC = () => {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [isResending, setIsResending] = useState(false);
  const [resendMessage, setResendMessage] = useState("");
  const [formError, setFormError] = useState("");
  const searchParams = useSearchParams();
  const [email, setEmail] = useState("");

  useEffect(() => {
    const emailParam = searchParams.get("email");
    if (emailParam) {
      setEmail(emailParam);
    }
  }, [searchParams]);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (isSubmitting) return;
    setIsSubmitting(true);
    setFormError("");
    const form = e.currentTarget as HTMLFormElement;
    const formData = new FormData(form);

    // Run the server action manually so we can surface errors in the UI.
    (async () => {
      try {
        await verifyOtp(formData);
      } catch (err: any) {
        const message =
          err instanceof ActionError
            ? err.message
            : err?.message || "Invalid verification code";
        setFormError(message);
      } finally {
        setIsSubmitting(false);
      }
    })();
  };

  const handleResend = async () => {
    if (!email) return;
    setIsResending(true);
    setResendMessage("");
    setFormError("");
    try {
      const formData = new FormData();
      formData.append("email", email);
      await resendOtpAction(formData);
      setResendMessage("Verification code resent successfully!");
    } catch (error: any) {
      const message =
        error instanceof ActionError
          ? error.message
          : error?.message || "Failed to resend code";
      setResendMessage(message);
    } finally {
      setIsResending(false);
    }
  };

  const inputRefs = useRef<(HTMLInputElement | HTMLTextAreaElement | null)[]>(
    []
  );
  const [otp, setOtp] = useState<string[]>(Array(OTP_LENGTH).fill(""));

  const handleChange = (index: number, value: string) => {
    const sanitized = value.replace(/[^0-9]/g, "").slice(0, 1);
    const newOtp = [...otp];
    newOtp[index] = sanitized;
    setOtp(newOtp);

    if (sanitized && index < OTP_LENGTH - 1) {
      inputRefs.current[index + 1]?.focus();
    }
  };

  const handleKeyDown = (
    e: React.KeyboardEvent<HTMLInputElement>,
    index: number
  ) => {
    if (e.key === "Backspace" && !otp[index] && index > 0) {
      inputRefs.current[index - 1]?.focus();
    }
  };

  return (
    <div className="sign-in-bg">
      <div className="app-wrapper d-block">
        <div className="main-container">
          <Container>
            <div className="sign-in-content-bg">
              <Row className="sign-in-content-bg">
                <Col lg={6} className="image-contentbox d-none d-lg-block">
                  <div className="form-container">
                    <div className="signup-content mt-4">
                      <span>
                        <img
                          alt="logo"
                          className="img-fluid"
                          src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png"
                        />
                      </span>
                    </div>
                    <div className="signup-bg-img">
                      <img
                        alt="background"
                        className="img-fluid"
                        src="/images/login/04.png"
                      />
                    </div>
                  </div>
                </Col>
                <Col lg={6} className="form-contentbox">
                  <div className="form-container">
                    <Form onSubmit={handleSubmit} className="app-form rounded-control">
                      <Row>
                        <Col xs={12}>
                          <div className="mb-5 text-center text-lg-start">
                            <h2 className="text-primary-dark">Verify OTP</h2>
                            <p>
                              Enter the {OTP_LENGTH} digit code sent to the registered
                              email Id
                            </p>
                          </div>
                        </Col>
                        {formError && (
                          <Col xs={12}>
                            <Alert color="danger" className="mb-3">
                              {formError}
                            </Alert>
                          </Col>
                        )}
                        <Col xs={12}>
                          <div className="verification-box d-flex gap-2 justify-content-lg-start mb-3">
                            {otp.map((digit, index) => (
                              <Input
                                key={index}
                                name={`otp${index}`}
                                type="text"
                                className="form-control h-60 w-60 text-center"
                                maxLength={1}
                                value={digit}
                                onChange={(e) =>
                                  handleChange(index, e.target.value)
                                }
                                onKeyDown={(e) => handleKeyDown(e, index)}
                                innerRef={(el) => {
                                  if (inputRefs.current) {
                                    inputRefs.current[index] = el;
                                  }
                                }}
                              />
                            ))}
                          </div>
                        </Col>
                        <Col xs={12}>
                          <p>
                            Did not receive a code?{" "}
                            <a
                              className="link-primary-dark text-decoration-underline"
                              href="#"
                              onClick={(e) => {
                                e.preventDefault();
                                handleResend();
                              }}
                            >
                              {isResending ? "Resending..." : "Resend!"}
                            </a>
                            {resendMessage && (
                              <span className="ms-2 text-success">{resendMessage}</span>
                            )}
                          </p>
                        </Col>
                        <input type="hidden" name="email" value={email} />
                        <Col xs={12}>
                          <FormGroup className="mb-3">
                            <Button
                              color="light-primary"
                              type="submit"
                              className="w-100"
                              disabled={isSubmitting}
                            >
                              {isSubmitting ? <Spinner size="sm" /> : "Verify"}
                            </Button>
                          </FormGroup>
                        </Col>
                      </Row>
                    </Form>
                  </div>
                </Col>
              </Row>
            </div>
          </Container>
        </div>
      </div>
    </div>
  );
};

export default VerifyOtpPage;
