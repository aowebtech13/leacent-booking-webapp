"use client";
import React from "react";
import {
  InputGroup,
  Input,
  InputGroupText,
  Container,
  Row,
  Accordion,
  AccordionHeader,
  AccordionBody,
  AccordionItem,
} from "reactstrap";
import Breadcrumbs from "@/Component/CommonElements/Breadcrumbs";
import { IconHelpCircle, IconSearch, IconStack2 } from "@tabler/icons-react";

type FaqItem = {
  id: string;
  title: string;
  content: string | React.ReactNode;
  isOpen?: boolean;
  icon?: React.ReactNode;
};

type AccordionSection = {
  title: string;
  items: FaqItem[];
  className?: string;
  parentId: string;
};

const FaqPage = () => {
  // FAQ data
  const faqSections: AccordionSection[] = [
    {
       title: "Books, Points & Unlocking",
       parentId: "accordionExample",
       items: [
         {
           id: "collapseOne",
           title: "How do I unlock a book?",
           isOpen: true,
           content:
             "Books are unlocked using points. Browse the book catalog, choose a book, and spend the required points to unlock it. Once unlocked, the book is added to your library and available to read anytime.",
         },
         {
           id: "collapseTwo",
           title: "What are points and how do I get them?",
           content:
             "Points are the in-app currency used to unlock books. You purchase points through book plans. Each plan grants a specific number of points, which are credited to your account immediately after a successful payment.",
         },
         {
           id: "collapseThree",
           title: "What are book plans?",
           content:
             "Book plans are purchasable packages that bundle points at different price tiers. Choose the plan that fits your reading needs, complete the payment, and the points are added to your balance. Plans may also include bonus points or discounts on larger purchases.",
         },
         {
           id: "collapseFour",
           title: "Can I unlock multiple books at once?",
           content:
             "Yes. As long as you have enough points in your balance, you can unlock any number of books. Each book costs a set number of points, which is shown on the book detail page before unlocking.",
         },
         {
           id: "collapseFive",
           title: "Do unlocked books expire?",
           content:
             "No. Once a book is unlocked with points, it stays in your library permanently and can be read offline or online at any time. Points, however, are non-refundable once spent.",
         },
       ],
    },
    {
      title: "Admin Dashboard",
      parentId: "nestingExample",
      className: "accordion-secondary app-accordion-plus",
      items: [
        {
          id: "nestingcollapseOne",
          title: "What is Admin Dashboard ?",
          isOpen: true,
          content:
            "The Admin Dashboard displays tabs for multiple pages that provide a personalized view of BI performance, data correctness, required cube maintenance and required administrative actions. These pages contain the results of detailed analyses, represented by links, images, graphs, pie charts and BI reports ...",
        },
        {
          id: "nestingcollapseTwo",
          title: "What is responsive Admin Dashboard",
          content:
            "An admin dashboard provides important data insights and controls for managing various aspects of an application or website. In this article, we will explore the process of creating a responsive admin dashboard using the three pillars of web development: HTML, CSS, and JavaScript.",
        },
        {
          id: "nestingcollapseThree",
          title: "Why cannot I see the dashboard in my workspace?",
          content:
            "Dashboards are not available for the customers with fiscal calendars.",
        },
        {
          id: "nestingcollapseFour",
          title: "What user role should I have to use dashboards?",
          content:
            "All workspace users can view dashboards and set up alerts on KPI changes (see Add an Alert to a KPI). Only workspace editors, explorers, and administrators can Create Dashboards.",
        },
        {
          id: "nestingcollapsefive",
          title: "Can I change the default date filter for a dashboard?",
          content:
            "Yes. Dashboards support sending regular emails with either the whole dashboard and/or individual insights from the dashboard (see Schedule Automatic Emailing of Dashboards). For each KPI on a dashboard, you can also set up email alerts to be notified when the KPI value reaches a certain threshold (see Add an Alert to a KPI).",
        },
      ],
    },
    {
      title: "Privacy & Policy",
      parentId: "accordionappflushExample",
      className: "accordion-flush accordion-light-primary",
      items: [
        {
          id: "appflush-collapseOne",
          title: "What is a Privacy Policy?",
          isOpen: true,
          content: (
            <>
              A Privacy Policy is a legal agreement designed to let visitors to
              your website or users of your app know what personal information
              you gather about them, how you use this information and how you
              keep it safe.
              <div
                className="accordion mt-2 app-accordion app-accordion-icon-left app-accordion-plus"
                id="nestingtwoExample"
              >
                {[
                  {
                    id: "nestingtwocollapseOne",
                    title: "What is privacy ?",
                    content:
                      "Privacy is the ability of an individual or group to seclude themselves or information about themselves, and thereby express themselves selectively.",
                  },
                  {
                    id: "nestingtwocollapseTwo",
                    title: "What is Policy ?",
                    content:
                      "Policy is a deliberate system of guidelines to guide decisions and achieve rational outcomes.",
                  },
                ].map((item) => (
                  <div className="accordion-item" key={item.id}>
                    <h2 className="accordion-header">
                      <button
                        className="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target={`#${item.id}`}
                        aria-expanded="false"
                      >
                        {item.title}
                      </button>
                    </h2>
                    <div
                      id={item.id}
                      className="accordion-collapse collapse"
                      data-bs-parent="#nestingtwoExample"
                    >
                      <div className="accordion-body">{item.content}</div>
                    </div>
                  </div>
                ))}
              </div>
            </>
          ),
        },
        {
          id: "appflush-collapseTwo",
          title: "what is diffusion privacy and policy",
          content:
            "The purpose of this Privacy Policy is to set out in an accountable and transparent way the collection and use of information by Diffusion. Information will only be collected for specified, explicit and legitimate purposes and not further processed in a manner that is incompatible with those purposes.",
        },
        {
          id: "appflush-collapseThree",
          title: "Why privacy policy is important",
          content:
            "The main reason to have a privacy policy is to convey to the clients that the business considers their privacy seriously. Several websites gather the client's information, and it is vital to let them know that their data is safe with the business.",
        },
      ],
    },
    {
      title: "Payment System",
      parentId: "nestingExample1",
      className:
        "accordion-flush app-accordion-plus app-accordion-icon-left accordion-light-success",
      items: [
        {
          id: "nestingcollapseplusOne1",
          title: "what is payment system",
          isOpen: true,
          content:
            "A payment system is any system used to settle financial transactions through the transfer of monetary value. This includes the institutions, payment instruments such as payment cards, people, rules, procedures, standards, and technologies that make its exchange possible.",
        },
        {
          id: "nestingcollapseplusTwo",
          title: "How many payment system types",
          content:
            "A payment can be made in the form of cash, check, wire transfer, credit card, or debit card. More modern methods of payment types leverage the Internet and digital platforms.",
        },
        {
          id: "nestingcollapseplusThree",
          title: "payment system example",
          content:
            "This includes debit cards, credit cards, electronic funds transfers, direct credits, direct debits, internet banking and e-commerce payment systems. Payment systems may be physical or electronic and each has its own procedures and protocols.",
        },
        {
          id: "nestingcollapseplusFour",
          title: "Different types of payment",
          content: (
            <ul>
              <li>- Credit Cards</li>
              <li>- Wire transfer</li>
              <li>- Debit card</li>
              <li>- Wallet</li>
              <li>- Online banking</li>
              <li>- Bank</li>
              <li>- Cash</li>
              <li>- Cheque</li>
            </ul>
          ),
        },
      ],
    },
  ];

  const [openMap, setOpenMap] = React.useState<Record<string, string>>({});

  const toggle = (sectionId: string, itemId: string) => {
    setOpenMap((prev) => ({
      ...prev,
      [sectionId]: prev[sectionId] === itemId ? "" : itemId,
    }));
  };

  return (
    <div>
      <Container fluid>
        <Breadcrumbs
          mainTitle="FAQ"
          title="Apps"
          path={["FAQ"]}
          Icon={IconStack2 as any}
        />
        <div className="faq-header text-center my-4">
          <img src="/images/logo/3.png" alt="Logo" />
          <h2 className="text-dark fw-bold">How Can We Help?</h2>
          <div className="app-form search-div mt-3">
            <InputGroup className="b-r-search">
              <InputGroupText className="bg-primary text-white border-0">
                <IconSearch size={18} />
              </InputGroupText>
              <Input type="text" placeholder="Search..." />
            </InputGroup>
          </div>
        </div>

        <Row className="faq-accordion">
          {faqSections.map((section) => (
            <React.Fragment key={section.parentId}>
              <div className="faq-heading mb-3">
                <h3>
                  <IconHelpCircle size={25} className="pe-2" /> {section.title}
                </h3>
              </div>
              <div className="col-lg-8 offset-lg-2 mb-3">
                <Accordion
                  open={openMap[section.parentId] || ""}
                  toggle={(id) => toggle(section.parentId, id)}
                  className={section.className || ""}
                >
                  {section.items.map((item) => (
                    <AccordionItem key={item.id}>
                      <AccordionHeader targetId={item.id}>
                        {item.icon || (
                          <IconHelpCircle size={25} className="pe-2" />
                        )}
                        {item.title}
                      </AccordionHeader>
                      <AccordionBody accordionId={item.id}>
                        {item.content}
                      </AccordionBody>
                    </AccordionItem>
                  ))}
                </Accordion>
              </div>
            </React.Fragment>
          ))}
        </Row>
      </Container>
    </div>
  );
};

export default FaqPage;
