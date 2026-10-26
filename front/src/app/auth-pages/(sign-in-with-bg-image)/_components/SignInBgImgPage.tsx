"use client";
import React, { useActionState, useEffect, useState } from "react";
import {
  Container,
  Row,
  Col,
  Form,
  FormGroup,
  Label,
  Input,
  Button,
  Spinner,
  Alert,
} from "reactstrap";
import Link from "next/link";
import Image from "next/image";
import { useRouter } from "next/navigation";
import {
  IconBrandFacebook,
  IconBrandGithub,
  IconBrandGoogle,
} from "@tabler/icons-react";
import { loginUserImg } from "@/lib/auth/action";
import { isRedirectError } from "@/lib/auth/action-error";
import { POST_LOGIN_PATH } from "@/lib/auth/constants";
import { useAuth } from "@/lib/contexts/AuthContext";

const SignInBgImgPage = () => {
  const router = useRouter();
  const { isAuthenticated, isLoading: authLoading, setAuth } = useAuth();

  const [state, formAction, isPending] = useActionState(
    async (_prev: { error: string | null }, formData: FormData) => {
      try {
        const res = await loginUserImg(formData);
        setAuth(res);
        return { error: null };
      } catch (err: any) {
        if (isRedirectError(err)) throw err;
        if (err?.name === "ActionError") {
          return { error: err.message };
        }
        return { error: err?.message || "Invalid credentials" };
      }
    },
    { error: null as string | null }
  );

  // Send signed in users to the app instead of the sign in form.
  useEffect(() => {
    if (!authLoading && isAuthenticated) {
      router.replace(POST_LOGIN_PATH);
    }
  }, [authLoading, isAuthenticated, router]);

  const [formData, setFormData] = useState({
    email: "",
    password: "",
    remember: false,
  });

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value, type, checked } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: type === "checkbox" ? checked : value,
    }));
  };

  return (
    <Container fluid>
      <Row>
        <Col xs={12} className="p-0">
          <div className="login-form-container">
            <div className="mb-4 text-center">
              <Link className="logo d-inline-block" href="/">
                <Image
                  src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1793002438/WhatsApp_Image_0008-10-26_at_01.07.28-removebg-preview-removebg-preview_giyzud.png"
                  className="w-250"
                  alt="logo"
                  width={201}
                  height={111}
                  sizes="250px"
                  priority
                />
              </Link>
            </div>

            <div className="form_container">
              <Form action={formAction} className="app-form rounded-control">
                <div className="mb-3 text-center">
                  <h3 className="text-primary-dark">Login to your Account</h3>
                  <p className="f-s-12 text-secondary">
                    Get started with our app, just create an account and enjoy
                    the experience.
                  </p>
                </div>

                {state.error && (
                  <Alert color="danger" className="mb-3">
                    {state.error}
                  </Alert>
                )}

                <FormGroup className="mb-">
                  <Label for="email">Email address</Label>
                  <Input
                    type="email"
                    id="email"
                    className="form-control b-r-20"
                    name="email"
                    value={formData.email}
                    onChange={handleChange}
                  />
                  <div className="form-text text">
                    We&#39;ll never share your email with anyone else.
                  </div>
                </FormGroup>
                <FormGroup className="mb-">
                  <Label for="username">Password</Label>
                  <Input
                    type="text"
                    id="password"
                    className="form-control b-r-20"
                    name="password"
                    value={formData.password}
                    onChange={handleChange}
                  />
                </FormGroup>
                <div className="mb-3 form-check">
                  <input
                    className="form-check-input"
                    id="formCheck1"
                    type="checkbox"
                  />
                  <label className="form-check-label" htmlFor="formCheck1">
                    remember me
                  </label>
                </div>

                <Button
                  type="submit"
                  color="light-primary"
                  className="w-100 mb-3 rounded"
                  disabled={isPending}
                >
                  {isPending ? <Spinner size="sm" /> : "Submit"}
                </Button>

                <div className="app-divider-v justify-content-center">
                  <p>OR</p>
                </div>

                <div className="text-center mb-3">
                  <Button
                    color="light-primary"
                    className="icon-btn btn b-r-5  m-1"
                  >
                    <IconBrandFacebook size={18} />
                  </Button>
                  <Button
                    color="light-danger"
                    className="icon-btn btn b-r-5  m-1"
                  >
                    <IconBrandGoogle size={18} />
                  </Button>
                  <Button
                    color="light-dark"
                    className="icon-btn btn b-r-5  m-1"
                  >
                    <IconBrandGithub size={18} />
                  </Button>
                </div>

                <div className="text-center">
                  <Link
                    href="/other-pages/terms-condition"
                    className="text-secondary text-decoration-underline"
                  >
                    Terms of use &amp; Conditions
                  </Link>
                </div>
              </Form>
            </div>
          </div>
        </Col>
      </Row>
    </Container>
  );
};

export default SignInBgImgPage;
