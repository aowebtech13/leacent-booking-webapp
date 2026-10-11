"use client";
import React, { useState, useEffect } from "react";
import { Col, Container, Row, Form, FormGroup, Label, Input, Button, Spinner } from "reactstrap";
import Link from "next/link";
import { useSearchParams } from "next/navigation";
import { resetPasswordAction } from "@/lib/auth/action";

const PasswordResetPage = () => {
  const [isSubmitting, setIsSubmitting] = useState(false);
  const searchParams = useSearchParams();
  const [token, setToken] = useState("");

  useEffect(() => {
    const tokenParam = searchParams.get("token");
    if (tokenParam) {
      setToken(tokenParam);
    }
  }, [searchParams]);

  const handleSubmit = () => {
    setIsSubmitting(true);
  };

  return (
    <div>
      <div className="sign-in-bg">
        <div className="app-wrapper d-block">
          <div className="main-container">
            <Container>
              <Row className="sign-in-content-bg">
                <Col lg={6} className="image-contentbox d-none d-lg-block">
                  <div className="form-container">
                    <div className="signup-content mt-4">
                      <span>
                        <img
                          src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png"
                          alt="logo"
                          className="img-fluid"
                        />
                      </span>
                    </div>

                    <div className="signup-bg-img">
                      <img
                        src="/images/login/03.png"
                        alt="background"
                        className="img-fluid"
                      />
                    </div>
                  </div>
                </Col>

                <Col lg={6} className="form-contentbox">
                  <div className="form-container">
                    <Form
                      action={resetPasswordAction}
                      onSubmit={handleSubmit}
                      className="app-form rounded-control"
                    >
                      <Row>
                        <Col xs={12}>
                          <div className="mb-5 text-center text-lg-start">
                            <h2 className="text-primary-dark f-w-600">
                              Reset Your Password
                            </h2>
                            <p>Create a new password and sign in to admin</p>
                          </div>
                        </Col>

                        <Col xs={12}>
                          <FormGroup className="mb-3">
                            <Label htmlFor="password">New Password</Label>
                            <Input
                              type="password"
                              id="password"
                              name="password"
                              placeholder="Enter Your Password"
                              required
                            />
                          </FormGroup>
                        </Col>

                        <Col xs={12}>
                          <FormGroup className="mb-3">
                            <Label htmlFor="password_confirmation">Confirm Password</Label>
                            <Input
                              type="password"
                              id="password_confirmation"
                              name="password_confirmation"
                              placeholder="Confirm Your Password"
                              required
                            />
                          </FormGroup>
                        </Col>

                        <input type="hidden" name="token" value={token} />

                        <Col xs={12}>
                          <div className="mb-3">
                            <Button
                              color="light-primary"
                              type="submit"
                              className="w-100"
                            >
                              {isSubmitting ? <Spinner size="sm" /> : "Reset Password"}
                            </Button>
                          </div>
                        </Col>
                      </Row>
                    </Form>
                  </div>
                </Col>
              </Row>
            </Container>
          </div>
        </div>
      </div>
    </div>
  );
};

export default PasswordResetPage;
